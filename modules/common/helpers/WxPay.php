<?php
namespace app\modules\common\helpers;


use Yii;
use yii\db\Query;
use yii\base\Exception;
use app\modules\common\models\ShopPayRecord;
use app\modules\common\services\KafkaService;
use app\modules\common\helpers\Commonfun;
use app\modules\shop\services\PayService;
use app\modules\shop\models\ShopGoods;
use app\modules\shop\models\ShopOrders;
use app\modules\shop\models\ShopOrdersDetail;

/*
 * 小程序微信支付
 */


class WxPay
{

    const SSLCERT_PATH = __DIR__ . '/apiclient_cert.pem';
    const SSLKEY_PATH = __DIR__ . '/apiclient_key.pem';
    /**
     * 微信小程序支付统一下单接口
     * @param $out_trade_no 商户订单号
     * @param $body 商品描述
     * @param $total_fee 订单金额 接口金额单位为：分
     * @param $openid 用户openid
     * @return array
     */
    public function unifiedorder($out_trade_no,$body,$total_fee,$openid)
    {
        $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $parameters = array(
            'appid' => \yii::$app->params["gl_shop_appid"], //小程序ID
            'mch_id' => \yii::$app->params["gl_shop_mch_id"], //商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'body' => $body,
            'out_trade_no' => $out_trade_no,
            'total_fee' => $total_fee,
            'spbill_create_ip' => $_SERVER['REMOTE_ADDR'], //终端IP
            'notify_url' => \YII::$app->params["userDomain"]."/api/pay/wx-pay/pay-notice", //通知地址确保外网能正常访问
            'openid' => $openid, //用户openid
            'trade_type' => 'JSAPI'//交易类型
        );
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $unifiedorder = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        if($unifiedorder['return_code']!='SUCCESS'){
            return ['code'=>109,'msg'=>'下单失败'.$unifiedorder['return_msg']];
        }
        if($unifiedorder['result_code']!='SUCCESS'){
            return ['code'=>109,'msg'=>'下单失败'.$unifiedorder['err_code'].$unifiedorder['err_code_des']];
        }
        $dataAry = array(
            'appId' => \yii::$app->params["gl_shop_appid"], //小程序ID
            'timeStamp' =>''.time().'', //时间戳
            'nonceStr' => $this->createNoncestr(), //随机串
            'package' => 'prepay_id='.$unifiedorder['prepay_id'], //数据包
            'signType' => 'MD5'//签名方式
        );
        //签名
        $dataAry['paySign'] = $this->getSign($dataAry);
        return ['code'=>600,'msg'=>'下单成功','data'=>$dataAry];
    }
    /**
     * 查询订单
     * $orderCode 订单号
     */
    public function queryOrder($orderCode){
        $url = 'https://api.mch.weixin.qq.com/pay/orderquery';
        $parameters = array(
            'appid' => \yii::$app->params["gl_shop_appid"], //小程序ID
            'mch_id' => \yii::$app->params["gl_shop_mch_id"], //商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'out_trade_no' => $orderCode,
            'sign_type' => 'MD5'//交易类型
        );
        //统一下单签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $unifiedorder = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        if($unifiedorder['result_code']!='SUCCESS'){
            return ['code'=>109,'msg'=>'查询失败'.$unifiedorder['result_msg']];
        }
        return ['code'=>600,'msg'=>'查询成功','data'=>$unifiedorder];

    }
    /**
     * 微信支付回调
     */
    public function notify($data){
        $postData = $data;  //微信支付成功，返回回调地址url的数据：XML转数组Array
        if($postData['return_code']=='FAIL'){
            return ['code'=>109,'msg'=>'返回信息错误'];
        }
        $postSign = $postData['sign'];//返回签名
        $transactionId = $postData['transaction_id'];//微信支付订单号
        $out_trade_no = $postData['out_trade_no'];//商户系统内部订单号
        $payTime = date("Y-m-d H:i:s",strtotime($postData['time_end']));//支付完成时间
        $orderMoney = $postData['total_fee'];//订单金额
        $payMoney = $postData['cash_fee'];//支付金额
        unset($postData['sign']);
        /* 微信官方提醒：
         *  商户系统对于支付结果通知的内容一定要做【签名验证】,
         *  并校验返回的【订单金额是否与商户侧的订单金额】一致，
         *  防止数据泄漏导致出现“假通知”，造成资金损失。
         */
        $sing = $this->getSign($postData);//生成签名
        //判断返回前面跟自己生成签名是否一致
        if($postSign!=$sing){
            return ['code'=>109,'msg'=>'签名不一致!post='.$postSign.'&my='.$sing];
        }
        //查询内部订单信息、已经处理过直接返回
        $payRecord = ShopPayRecord::find()
            ->where(["order_code"=>$out_trade_no,"status"=>0,"pay_way"=>2])
            ->one();
        if(empty($payRecord)){
            return true;
        }else{
            //判断订单金额是否一致,不一致直接返回
            if($orderMoney!=$payRecord->pre_money*100){
                return ['code'=>109,'msg'=>'订单金额不一致!post='.$orderMoney.'&my='.$payRecord->pre_money*100];
            }
            //更新交易记录
            $payRecord->outer_code = $transactionId;
            $payRecord->pay_money = $payMoney/100;
            $payRecord->status = 1;
            $payRecord->pay_time =$payTime;
            $db = \Yii::$app->db;
            $trans = $db->beginTransaction();
            try{
                if(!$payRecord->save()){
                    throw new Exception('交易明细数据更新失败');
                }

                $str = '';
                $str .= "update shop_orders set order_status = 1,pay_status =1,pay_time ='{$payTime}',wxpay_data ='' where order_code = '{$out_trade_no}' AND order_status = 0 AND pay_status = 0;";//更新订单状态
                //更新商品销售量
//                $field = ['shop_orders_detail.goods_id','shop_orders_detail.sku_num'];
//                $goodsData = ShopOrdersDetail::find()
//                        ->select($field)
//                        ->leftJoin('shop_orders o','o.order_id = shop_orders_detail.order_id')
//                        ->where(['o.order_code'=>$out_trade_no])
//                        ->asArray()
//                        ->all();
//                foreach ($goodsData as $v){
//                    $str .="update shop_goods set sale_nums = sale_nums + {$v['sku_num']} WHERE goods_id = {$v['goods_id']}";
//                }
                $ret = $db->createCommand($str)->execute();
                if(!$ret){
                    throw new Exception('订单状态、商品销量数据更新失败!');
                }
                $trans->commit();
                return ['code'=>600,'msg'=>'订单处理完毕！'];
            }catch (Exception $e){
                $trans->rollBack();
                return ['code'=>109,'msg'=>$e->getMessage()];
            }
        }
    }

    /**
     * 关闭订单
     * @param $orderCode 订单编号
     *
     */
    public function colseOrder($orderCode){
        $url = 'https://api.mch.weixin.qq.com/pay/closeorder';
        $parameters = array(
            'appid' => \yii::$app->params["gl_shop_appid"], //小程序ID
            'mch_id' => \yii::$app->params["gl_shop_mch_id"], //商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'out_trade_no' => $orderCode,
            'sign_type' => 'MD5'//交易类型
        );
        //签名
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $unifiedorder = $this->xmlToArray($this->postXmlCurl($xmlData, $url, 60));
        if($unifiedorder['return_code']!='SUCCESS'){
            return ['code'=>109,'msg'=>'订单关闭失败'.$unifiedorder['return_msg']];
        }
        return ['code'=>600,'msg'=>'订单关闭成功','data'=>$unifiedorder];
    }

    /**
     * 申请退款
     * @param $orderCode 订单号
     */
    public function requestRefund($orderCode){
        $payRecord = ShopPayRecord::find()->where(['order_code'=>$orderCode,'pay_type'=>1,'status'=>1])->asArray()->one();
        if(empty($payRecord)){
            return ['code'=>109,'msg'=>'未找到符合条件支付记录，不可退款'];
        }
        $url = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
        $refundCode = Commonfun::getCode("SP", "R");//内部退款编号
        $parameters = array(
            'appid' => \yii::$app->params["gl_shop_appid"], //小程序ID
            'mch_id' => \yii::$app->params["gl_shop_mch_id"], //商户号
            'nonce_str' => $this->createNoncestr(), //随机字符串
            'out_trade_no' => $orderCode,
            'sign_type' => 'MD5',//交易类型
            'out_refund_no'=>$refundCode,
            'total_fee' => floatval($payRecord['pre_money']*100),
            'refund_fee' =>floatval($payRecord['pre_money']*100),
            'notify_url' => \YII::$app->params["userDomain"]."/api/pay/wx-pay/refund-notice", //通知地址确保外网能正常访问
        );
        $parameters['sign'] = $this->getSign($parameters);
        $xmlData = $this->arrayToXml($parameters);
        $unifiedorder = $this->xmlToArray($this->postXmlSSLCurl($xmlData, $url, 60));
        if($unifiedorder['result_code']=='FAIL'){
            return ['code'=>109,'msg'=>'申请失败，'.$unifiedorder['err_code_des']];
        }
        //新增退款记录
        $payService = new PayService();
        $payService->createOrUpdateRefundRecord($orderCode,1,$refundCode);
        return ['code'=>600,'msg'=>'申请成功'];
    }

    /**
     * 微信退款回调通知
     * $data 回调内容
     */
    public function refundNotify($data){
        $postData = $data;
        if($postData['return_code']=='FAIL'){
            return ['code'=>109,'msg'=>'返回信息错误'];
        }
        $reqInfo = $postData['req_info'];//返回加密字符串
        //解密
        $key = md5(\YII::$app->params["gl_shop_pay_key"]);//md5支付秘钥
        $refundXml = $this->refund_decrypt($reqInfo,$key);
        //解密完XML转数组
        $refundAry = $this->xmlToArray($refundXml);
        if($refundAry['refund_status']!='SUCCESS'){
            return ['code'=>109,'msg'=>'退款状态错误'];
        }
        //退款成功更新退款记录
        $orderCode = $refundAry['out_trade_no'];//商户订单号
        $refundId = $refundAry['refund_id'];//微信退款订单号
        $outRefundNo = $refundAry['out_refund_no'];//商户退款订单号
        $refundTime = $refundAry['success_time'];//资金退款至用户帐号的时间
        //查询内部订单信息、已经处理过直接返回
        $payRecord = ShopPayRecord::find()
            ->where(["refund_code"=>$outRefundNo,"status"=>0,"pay_type"=>2])
            ->one();
        if(empty($payRecord)){
            return ['code'=>600,'msg'=>'处理成功'];
        }else{
            $payService = new PayService();
            $ret = $payService->createOrUpdateRefundRecord($orderCode,2,$refundId,$refundTime);
            if($ret['code']!=600){
                return ['code'=>109,'msg'=>$ret['msg']];
            }
            //更新订单状态
            ShopOrders::updateAll(['order_status'=>3],['order_code'=>$orderCode,'pay_status'=>1]);
            return ['code'=>600,'msg'=>'处理完毕'];
        }
    }

    private static function postXmlCurl($xml, $url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); //严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);


        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
        curl_setopt($ch, CURLOPT_TIMEOUT, 40);
        set_time_limit(0);


        //运行curl
        $data = curl_exec($ch);

        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            curl_close($ch);
        }
    }


    //数组转换成xml
    private function arrayToXml($arr)
    {
        $xml = "<root>";
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $xml .= "<" . $key . ">" . arrayToXml($val) . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
        }
        $xml .= "</root>";
        return $xml;
    }


    //xml转换成数组
    public function xmlToArray($xml)
    {


        //禁止引用外部xml实体


        libxml_disable_entity_loader(true);


        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);


        $val = json_decode(json_encode($xmlstring), true);


        return $val;
    }


    //作用：产生随机字符串，不长于32位
    private function createNoncestr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    //作用：生成签名
    private function getSign($Obj)
    {
        foreach ($Obj as $k => $v) {
            $Parameters[$k] = $v;
        }
        //签名步骤一：按字典序排序参数
        ksort($Parameters);
        $String = $this->formatBizQueryParaMap($Parameters, false);
        //签名步骤二：在string后加入KEY
        $String = $String . "&key=" . \yii::$app->params["gl_shop_pay_key"];
        //签名步骤三：MD5加密
        $String = md5($String);
        //签名步骤四：所有字符转为大写
        $result_ = strtoupper($String);
        return $result_;
    }


    ///作用：格式化参数，签名过程需要使用
    private function formatBizQueryParaMap($paraMap, $urlencode)
    {
        $buff = "";
        ksort($paraMap);
        foreach ($paraMap as $k => $v) {
            if ($urlencode) {
                $v = urlencode($v);
            }
            $buff .= $k . "=" . $v . "&";
        }
        $reqPar;
        if (strlen($buff) > 0) {
            $reqPar = substr($buff, 0, strlen($buff) - 1);
        }
        return $reqPar;
    }
    /*
    * 给微信发送确认订单金额和签名正确，SUCCESS信息
    */
    public function return_success($code,$msg){
        $xml_post = '<xml>
                    <return_code>'.$code.'</return_code>
                    <return_msg>'.$msg.'</return_msg>
                    </xml>';
        return $xml_post;
    }
    //需要使用证书的CURL请求
    function postXmlSSLCurl($xml,$url,$second=30)
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        //这里设置代理，如果有的话
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //设置header
        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        //设置证书
        //使用证书：cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT, self::SSLCERT_PATH);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY, self::SSLKEY_PATH);
        //post提交方式
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$xml);
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        }else {
            $error = curl_errno($ch);
            echo "curl出错，错误码:$error"."<br>";
            curl_close($ch);
            return false;
        }
    }
    //退款通知字符串解密
    public  function refund_decrypt($str,$key) {
        $str = base64_decode($str);
        $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB);
        $block = mcrypt_get_block_size('rijndael_128', 'ecb');
        $pad = ord($str[($len = strlen($str)) - 1]);
        $len = strlen($str);
        $pad = ord($str[$len - 1]);
        return substr($str, 0, strlen($str) - $pad);
    }
}


