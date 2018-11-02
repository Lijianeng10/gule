<?php

namespace app\modules\store\services;

use app\modules\common\models\Store;
use app\modules\common\models\Machine;
use app\modules\common\models\Lottery;
use app\modules\common\helpers\Commonfun;
use app\modules\common\models\Terminal;
use Yii;
use yii\base\Exception;
use app\modules\common\models\StoreLottery;
use yii\db\Expression;
use app\modules\common\models\PayRecord;
use app\modules\common\models\Order;
use app\modules\common\models\OrderDetail;
use app\modules\tools\helpers\PayTool;
use app\modules\common\helpers\Constants;

class StoreService {

    /**
     * 获取跳转页面
     * @param type $custNo
     * @param type $terminalNum
     * @return type
     */
    public static function toJumpPage($custNo, $terminalNum) {
        $machineData = Machine::find()->select(['cust_no', 'machine_code', 'terminal_num', 'status'])->where(['terminal_num' => $terminalNum])->asArray()->one();
        if ($custNo) {
            if (empty($machineData)) {
                $terminal = Terminal::find()->select(['terminal_num'])->where(['terminal_num' => $terminalNum, 'use_status' => 0])->asArray()->one();
                if(empty($terminal)) {
                    return ['code' => 109, 'msg' => '此终端号已被占用'];
                }
                $url = \Yii::$app->params['userDomain'] . '/h5_ggc/activate.html?terminalNum=' . $terminalNum . '&custNo=' . $custNo; // 跳转激活页面
            } else {
                if ($machineData['status'] != 1) {
                    return ['code' => 109, 'msg' => '该机器已被禁用'];
                }
                if ($machineData['cust_no'] == $custNo) {
                    $url = \Yii::$app->params['userDomain'] . '/h5_ggc/store.html?custNo=' . $custNo; // 跳转门店管理页面
                } elseif ($machineData['cust_no'] != $custNo) {
                    $url = \Yii::$app->params['userDomain'] . '/h5_ggc/purchase.html?terminalNum=' . $terminalNum . '&custNo=' . $machineData['cust_no'] . '&machineCode=' . $machineData['machine_code']; // 跳转购彩页面
                }
            }
        } else {
            if (empty($machineData)) {
                return ['code' => 109, 'msg' => '该机器未激活！请联系店主'];
            } elseif ($machineData['status'] == 1) {
                $url = \Yii::$app->params['userDomain'] . '/h5_ggc/purchase.html?terminalNum=' . $terminalNum . '&custNo=' . $machineData['cust_no'] . '&machineCode=' . $machineData['machine_code']; // 跳转购彩页
            } elseif ($machineData['status'] == 0) {
                return ['code' => 109, 'msg' => '该机器已被禁用！请联系店主'];
            }
        }
        return ['code' => 600, 'msg' => '获取成功', 'data' => $url];
    }

    /**
     * 激活机器
     * @param type $custNo
     * @param type $terminalNum
     * @param type $machineCode
     * @param type $sellValue
     * @return type
     */
    public static function activeMachine($custNo, $terminalNum, $machineCode) {
        $terminal = Terminal::find()->select(['terminal_id', 'use_status'])->where(['terminal_num' => $terminalNum, 'status' => 1])->asArray()->one();
        if (empty($terminal)) {
            return ['code' => 109, 'msg' => '此终端码已被禁用'];
        }
        if ($terminal['use_status'] != 0) {
            return ['code' => 109, 'msg' => '此终端码已被绑定'];
        }
        $machineData = Machine::find()->select(['cust_no', 'machine_code', 'terminal_num'])->where(['machine_code' => $machineCode, 'status' => 1])->asArray()->one();
        if ($machineData) {
            return ['code' => 109, 'msg' => '该机器码已被激活绑定'];
        }
        $validateMachine = self::validateMachine($machineCode);
        if ($validateMachine['code'] != 600) {
            return ['code' => 109, 'msg' => '验签失败！请稍后再试'];
        }
        if ($validateMachine['online'] === false) {
            return ['code' => 110, 'msg' => '请确认机器电源已接通并输入正确的机器码'];
        }
        $store = Store::findOne(['cust_no' => $custNo]);
        if (empty($store)) {
            $storeData = self::getStoreData($custNo);
            if ($storeData['code'] != 1) {
                return ['code' => 109, 'msg' => $storeData['msg']];
            }
            $channelNo = array_slice(explode('.', $storeData['data']['cascadeId']),-2,1);
            $store = new Store();
            $store->cust_no = $custNo;
            $store->channel_no = $channelNo[0];
            $store->store_name = $storeData['data']['storeName'];
            $store->user_tel = $storeData['data']['phone'];
            $store->province = $storeData['data']['province'];
            $store->city = $storeData['data']['city'];
            $store->area = $storeData['data']['conuntry'];
            $store->address = $storeData['data']['address'];
            $store->create_time = date('Y-m-d H:i:s');
        } elseif ($store->status == 2) {
            return ['code' => 109, 'msg' => '门店已被禁用停止权限，请联系渠道管理员'];
        }
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            $machine = new Machine();
            $machine->terminal_num = $terminalNum;
            $machine->machine_code = $machineCode;
            $machine->cust_no = $custNo;
            $machine->channel_no = $store->channel_no;
//            $machine->lottery_value = $sellValue;
            $machine->ac_status = 1;
            $machine->online_status = 1;
            $machine->create_time = date('Y-m-d H:i:s');
            if (!$machine->save()) {
                throw new Exception('激活失败！');
            }
            $store->status = 1;
            if (!$store->save()) {
                throw new Exception('门店绑定激活失败！');
            }
            $ret = Terminal::updateAll(['use_status' => 1], ['terminal_num' => $terminalNum]);
            if (!$ret) {
                throw new Exception('终端码状态更新失败！');
            }
            $bindingRet = self::bindingServer($terminalNum, $machineCode);
            if ($bindingRet['code'] != 600) {
                throw new Exception($bindingRet['msg']);
            }
            $trans->commit();
            return ['code' => 600, 'msg' => '激活成功', 'data' => ['custNo' => $custNo, 'terminalNum' => $terminalNum, 'machineCode' => $machineCode]];
        } catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 验证机器是否存在
     * @param type $machineCode
     * @return type
     */
    public static function validateMachine($machineCode) {
        $url = \Yii::$app->params['machine_service'] . 'conn_search';
        $sign = Commonfun::getSign($machineCode);
        $postData = ['machine_no' => $machineCode, 'sign' => $sign];
        $ret = \Yii::sendCurlPost($url, $postData);
        return $ret;
    }

    /**
     * 获取门店信息
     * @param type $custNo
     * @return type
     */
    public static function getStoreData($custNo) {
        $url = \Yii::$app->params['java_get_store'];
        $postData = ['custNo' => $custNo];
        $ret = \Yii::sendCurlPost($url, $postData);
        return $ret;
    }

    /**
     * 获取彩种
     * @param type $custNo
     * @return type
     */
    public static function getLottery($custNo) {
        $storeLottery = StoreLottery::find()->select(['l.lottery_id', 'lottery_value', 'l.lottery_name'])
                ->innerJoin('lottery l', 'l.lottery_id = store_lottery.lottery_id')
                ->where(['store_lottery.cust_no' => $custNo])
                ->andWhere(['>', 'store_lottery.stock', 0])
                ->asArray()
                ->all();
        $lottData = [];
        $valueData = [];
        $lotteryValue = [];
        foreach ($storeLottery as $lottery) {
            $lottData[] = ['lottery_id' => $lottery['lottery_id'], 'lottery_name' => $lottery['lottery_name']];
            $valueData[] = $lottery['lottery_value'];
            if (array_key_exists($lottery['lottery_value'], $lotteryValue)) {
                if (!array_key_exists($lottery['lottery_id'], $lotteryValue['lottery'])) {
                    $lotteryValue[$lottery['lottery_value']]['lottery'][$lottery['lottery_id']] = ['lottery_id' => $lottery['lottery_id'], 'lottery_name' => $lottery['lottery_name']];
                }
            } else {
                $lotteryValue[$lottery['lottery_value']]['lottery'][$lottery['lottery_id']] = ['lottery_id' => $lottery['lottery_id'], 'lottery_name' => $lottery['lottery_name']];
            }
        }
        $data['lottery'] = $lottData;
        $data['value'] = $valueData;
        $data['lotteryValue'] = $lotteryValue;
        return $data;
    }

    /**
     * 修改设备出售的彩种面额
     * @param type $custNo
     * @param type $terminalNum
     * @param type $lottery
     * @param type $lotteryValue
     * @param type $machineCode
     * @return type
     */
    public static function changeMachineLottery($custNo, $terminalNum, $lottery, $lotteryValue, $machineCode) {
        $machine = Machine::findOne(['cust_no' => $custNo, 'machine_code' => $machineCode, 'terminal_num' => $terminalNum]);
        if (empty($machine)) {
            return ['code' => 109, 'msg' => '请确认此设备已激活'];
        }
        $lotteryData = StoreLottery::find()->select(['stock'])->where(['lottery_id' => $lottery, 'lottery_value' => $lotteryValue, 'cust_no' => $custNo])->asArray()->one();
        if (empty($lotteryData)) {
            return ['code' => 109, 'msg' => '您无出售此彩种面额的权限'];
        }
        if ($lotteryData['stock'] <= 0) {
            return ['code' => 109, 'msg' => '您暂无此彩种面额的库存,请重新选择出售彩种面额'];
        }
        $machine->lottery_id = $lottery;
        $machine->lottery_value = $lotteryValue;
        if (!$machine->save()) {
            return ['code' => 109, 'msg' => '出售彩种面额修改失败'];
        }
        return ['code' => 600, 'msg' => '修改成功,请及时更新机箱内的彩种面值'];
    }

    /**
     * 修改设备库存
     * @param type $custNo
     * @param type $terminalNum
     * @param type $machineCode
     * @param type $activeType
     * @param type $stock
     * @return type
     * @throws Exception
     */
    public static function changeMachineStock($custNo, $terminalNum, $machineCode, $activeType, $stock) {
        $machine = Machine::findOne(['cust_no' => $custNo, 'machine_code' => $machineCode, 'terminal_num' => $terminalNum]);
        if (empty($machine)) {
            return ['code' => 109, 'msg' => '请确认此设备已激活'];
        }
        if ($activeType == 1) {
            $update = ['stock' => new Expression('stock+' . $stock)];
        } else {
            if ($stock > $machine->stock) {
                return ['code' => 109, 'msg' => '机箱内的库存不足扣除量'];
            }
            $update = ['stock' => new Expression('stock-' . $stock)];
            $prePayMoney = $stock * $machine->lottery_value;
        }
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            $storeLottery = StoreLottery::find()->select(['stock'])->where(['lottery_id' => $machine->lottery_id, 'lottery_value' => $machine->lottery_value, 'cust_no' => $custNo])->asArray()->one();
            if ($storeLottery['stock'] < $stock) {
                throw new Exception('门店此彩种库存不足');
            }
            if ($activeType == 2) {
                $payCreate = self::createPayRecord($custNo, $terminalNum, $machine->channel_no, $prePayMoney);
                if ($payCreate['code'] != 600) {
                    throw new Exception($payCreate['msg']);
                }
//                $storeUp = ['stock' => new Expression('stock-' . $stock)];
                $storeLotteryRet = StoreLottery::updateAll($update, ['cust_no' => $custNo, 'lottery_id' => $machine->lottery_id, 'lottery_value' => $machine->lottery_value]);
                if ($storeLotteryRet === false) {
                    throw new Exception('库存修改失败-门店彩种');
                }
            }
            $upMachine = Machine::updateAll($update, ['cust_no' => $custNo, 'machine_code' => $machineCode, 'terminal_num' => $terminalNum]);
            if ($upMachine === false) {
                throw new Exception('库存修改失败-机器');
            }
            if ($activeType == 2) {
                $payRecord = PayRecord::findOne(['pay_record_id' => $payCreate['recordId']]);
                $payRecord->buy_nums = $stock;
                $payRecord->lottery_id = $machine->lottery_id;
                $payRecord->lottery_value = $machine->lottery_value;
                $payRecord->status = 1;
                $payRecord->pay_money = $prePayMoney;
                $payRecord->pay_time = date('Y-m-d H:i:s');
                $payRecord->modify_time = date('Y-m-d H:i:s');
                if (!$payRecord->save()) {
                    throw new Exception('库存修改失败-记录');
                }
            }
            $trans->commit();
            return ['code' => 600, 'msg' => '库存修改成功'];
        } catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 生成交易明细
     * @param type $custNo
     * @param type $terminalNum
     * @param type $channelNo
     * @param type $prePayMoney
     * @return type
     */
    public static function createPayRecord($custNo, $terminalNum, $channelNo, $prePayMoney, $payType = 1) {
        $payRecord = new PayRecord();
        $orderCode = Commonfun::getCode('ORDER', 'T');
        $payRecord->order_code = $orderCode;
        $payRecord->store_no = $custNo;
        $payRecord->channel_no = $channelNo;
        $payRecord->terminal_num = $terminalNum;
        $payRecord->pre_pay_money = $prePayMoney;
        $payRecord->create_time = date('Y-m-d H:i:s');
        $payRecord->pay_type = $payType;
        if (!$payRecord->save()) {
            return ['code' => 109, 'msg' => '交易记录生成失败'];
        }
        return ['code' => 600, 'msg' => '交易记录生成成功', 'recordId' => $payRecord->pay_record_id, 'orderCode' => $payRecord->order_code];
    }

    /**
     * 获取门店详情
     * @param type $custNo
     * @return type
     */
    public static function getStoreDetail($custNo) {
        $date = date('Y-m-d');
        $month = date('Y-m');
        $where = "DATE_FORMAT(p.pay_time,'%Y-%m-%d') = '{$date}'";
        $where1 = "DATE_FORMAT(p.pay_time, '%Y-%m') = '{$month}'";
        $field = ['store.cust_no', 'user_tel', 'channel_no',
            new Expression("case when store.status = 1 then (select coalesce(sum(p.pay_money),0) from pay_record p where p.store_no = store.cust_no and p.status = 1 and {$where}) end date_sell_amount"),
            new Expression("case when store.status = 1 then (select coalesce(sum(p.pay_money),0) from pay_record p where p.store_no = store.cust_no and p.status = 1 and {$where1}) end month_sell_amount")];
        $storeData = Store::find()->select($field)->where(['cust_no' => $custNo, 'store.status' => 1])->asArray()->one();
        if (empty($storeData)) {
            return ['code' => 109, 'msg' => '请先激活绑定'];
        }
        $field1 = ['terminal_num', 'machine_code', 'lottery_value', 'stock', 'ac_status', 'online_status', 'machine.status', 'l.lottery_name', 'cust_no', 'l.lottery_img',
            new Expression("case when machine.status = 1 then (select coalesce(sum(p.buy_nums),0) from pay_record p where p.terminal_num = machine.terminal_num and p.store_no = machine.cust_no and p.status = 1 and {$where}) end sell_count"),
            new Expression("case when machine.status = 1 then (select coalesce(sum(p.pay_money),0) from pay_record p where p.terminal_num = machine.terminal_num and p.store_no = machine.cust_no and p.status = 1 and {$where}) end sell_amount")];
        $machineData = Machine::find()->select($field1)
                ->leftJoin('lottery l', 'l.lottery_id = machine.lottery_id')
                ->where(['cust_no' => $custNo, 'machine.status' => 1])
                ->asArray()
                ->all();
        $storeData['machine_nums'] = count($machineData);
        $storeData['machine'] = $machineData;
        return ['code' => 600, 'msg' => '获取成功', 'data' => $storeData];
    }

    /**
     * 获取销售列表
     * @param type $custNo
     * @param type $page
     * @param type $size
     * @return type
     */
    public static function getSaleList($custNo, $page, $size) {
        $field = ['order_code', 'store_no', 'channel_no', 'terminal_num', 'pay_money', 'buy_nums', 'create_time', 'lottery_value', 'pay_time'];
        $query = PayRecord::find()->select($field)->where(['store_no' => $custNo, 'status' => 1]);
        $pn = 1;
        $pages = 1;
        if ($page) {
            $pn = $page;
            $total = $query->count();
            $pages = ceil($total / $size);
            $offset = ($page - 1) * $size;
            $query = $query->limit($size)->offset($offset);
        }
        $saleList = $query->orderBy('create_time desc')->asArray()->all();
        return ['page' => $pn, 'pages' => $pages, 'size' => count($saleList), 'total' => empty($page) ? count($saleList) : $total, 'data' => $saleList];
    }

    /**
     * 获取进货记录列表
     * @param type $custNo
     * @param type $page
     * @param type $size
     * @return type
     */
    public static function getStockList($custNo, $page, $size) {
        $field = ['lottery_id', 'lottery_name', 'sub_value', 'sub_value', 'sheet_nums', 'price', 'money', 'o.order_status'];
        $query = OrderDetail::find()->select($field)
                ->innerJoin('order o', 'o.order_id = order_detail.order_id')
                ->where(['o.cust_no' => $custNo, 'o.pay_status' => 1]);
        $pn = 1;
        $pages = 1;
        if ($page) {
            $pn = $page;
            $total = $query->count();
            $pages = ceil($total / $size);
            $offset = ($page - 1) * $size;
            $query = $query->limit($size)->offset($offset);
        }
        $orderList = $query->orderBy('create_time desc')->asArray()->all();
        return ['page' => $pn, 'pages' => $pages, 'size' => count($orderList), 'total' => empty($page) ? count($orderList) : $total, 'data' => $orderList];
    }

    /**
     * 获取设备销售商品
     * @param type $custNo
     * @param type $terminalNum
     * @param type $machineCode
     * @return type
     */
    public static function getMachineGoods($custNo, $terminalNum, $machineCode) {
        $field = ['terminal_num', 'machine_code', 'cust_no', 'l.lottery_value', 'stock', 'l.lottery_name', 'l.lottery_img'];
        $goods = Machine::find()->select($field)
                ->innerJoin('lottery l', 'l.lottery_id = machine.lottery_id')
                ->where(['machine.status' => 1, 'online_status' => 1, 'ac_status' => 1, 'cust_no' => $custNo, 'terminal_num' => $terminalNum, 'machine_code' => $machineCode])
                ->asArray()
                ->one();
        if (empty($goods)) {
            return ['code' => 109, 'msg' => '该设备可能还未激活！请联系店主'];
        }
        return ['code' => 600, 'msg' => '获取成功', 'data' => $goods];
    }

    /**
     * 设备开锁
     * @param type $custNo
     * @param type $terminalNum
     * @param type $machineCode
     * @return type
     */
    public static function openMachine($custNo, $terminalNum, $machineCode) {
        $machine = Machine::find()->select(['machine_code'])->where(['cust_no' => $custNo, 'terminal_num' => $terminalNum, 'machine_code' => $machineCode, 'machine.status' => 1, 'ac_status' => 1])->asArray()->one();
        if (empty($machine)) {
            return ['code' => 109, 'msg' => '请确认已激活该设备'];
        }
        $url = \Yii::$app->params['machine_service'] . 'open';
        $sign = Commonfun::getSign($machineCode);
        $postData = ['machine_no' => $machineCode, 'sign' => $sign];
        $ret = \Yii::sendCurlPost($url, $postData);
        if ($ret['code'] != 600) {
            return ['code' => 109, 'msg' => '验签失败，请稍后再试'];
        }
        if ($ret['online'] === false) {
            return ['code' => 109, 'msg' => '请确认机器已连接电源且网络连接正常'];
        }
        if ($ret['result'] === false) {
            return ['code' => 109, 'msg' => '开锁失败，请稍后再试'];
        }
        return ['code' => 600, 'msg' => '开锁成功'];
    }

    /**
     * 订单下单
     * @param type $custNo
     * @param type $terminalNum
     * @param type $machineCode
     * @param type $buyNums
     * @param type $total
     * @return type
     */
    public static function playOrder($custNo, $terminalNum, $machineCode, $buyNums, $total) {
        $machine = Machine::find()->select(['machine_code', 'lottery_id', 'lottery_value', 'stock', 'channel_no'])->where(['cust_no' => $custNo, 'terminal_num' => $terminalNum, 'machine_code' => $machineCode, 'machine.status' => 1, 'ac_status' => 1])->asArray()->one();
        if (empty($machine)) {
            return ['code' => 109, 'msg' => '设备故障！请联系店主'];
        }
        if (bccomp($buyNums, $machine['stock']) == 1) {
            return ['code' => 109, 'msg' => '购买张数大于机箱内库存'];
        }
        $prePayMoney = bcmul($buyNums, $machine['lottery_value']);
        if (bccomp($prePayMoney, $total) != 0) {
            return ['code' => 109, 'msg' => '购买总金额错误'];
        }
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            $createOrder = self::createPayRecord($custNo, $terminalNum, $machine['channel_no'], $total);
            if ($createOrder['code'] != 600) {
                throw new Exception('下单失败-记录');
            }
            $payRecord = PayRecord::findOne(['pay_record_id' => $createOrder['recordId']]);
            $qbRet = PayTool::createQbThePublic($custNo, $createOrder['orderCode'], $total);
            if ($qbRet["code"] != 1) {
                $qbMsg = isset($qbRet['msg']) ? $qbRet['msg'] : '';
                $msg = '下单失败！！' . $qbMsg;
                throw new Exception($msg);
            }
            $payRecord->lottery_id = $machine['lottery_id'];
            $payRecord->buy_nums = $buyNums;
            $payRecord->lottery_value = $machine['lottery_value'];
            $payRecord->outer_no = $qbRet['orderNo']; //钱包支付二维码返回的唯一交易单号
            $payRecord->save();
            $trans->commit();
            return ['code' => 600, 'msg' => '下单成功', 'data' => ['create_time' => $payRecord->create_time, 'order_code' => $payRecord->order_code, 'pay_money' => $total, 'pay_url' => $qbRet['pay_url']]];
        } catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 订单回调
     * @param type $orderCode
     * @param type $outerNo
     * @param type $totalAmount
     * @param type $payTime
     * @param type $custNo
     * @param type $payChannel
     * @return type
     * @throws Exception
     */
    public static function orderNotify($orderCode, $outerNo, $totalAmount, $payTime, $custNo, $payChannel) {
        $payRecord = PayRecord::findOne(['cust_no' => $custNo, 'order_code' => $orderCode, 'status' => 0]);
        if (empty($payRecord)) {
            return ['code' => 109, 'msg' => '该订单不存在或已支付'];
        }
        $payRecord->outer_code = $outerNo;
        $payRecord->pay_way = $payChannel == '01' ? 1 : 2;
        $payRecord->pay_money = $totalAmount;
        $payRecord->pay_time = $payTime;
        $payRecord->status = 1;
        $payRecord->modify_time = date('Y-m-d H:i:s');
        if (!$payRecord->save()) {
            return ['code' => 109, 'msg' => '交易记录更新失败'];
        }
        //调出票指令
        $valueLength = Constants::VALUE_LENGTH;
        $url = \Yii::$app->params['order_service'] . 'add';
        $md5Code = $payRecord->terminal_num . $payRecord->order_code;
        $sign = Commonfun::getSign($md5Code);
        $postData = ['cust_no' => $payRecord->terminal_num, 'order_no' => $payRecord->order_code, 'price' => $payRecord->lottery_value, 'quantity' => $payRecord->buy_nums, 'lottery_length' => $valueLength[$payRecord->value], 'sign' => $sign];
        $ret = \Yii::sendCurlPost($url, $postData);
        if ($ret['code'] != 600) {
            return ['code' => 109, 'msg' => $ret['msg']];
        }
        $update = ['stock' => new Expression('stock-' . $payRecord->buy_nums)];
        $machine = Machine::find()->select(['terminal_num', 'machine_code'])->where(['cust_no' => $custNo, 'terminal_num' => $payRecord->terminal_num, 'status' => 1])->asArray()->one();
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            $storeLotteryRet = StoreLottery::updateAll($update, ['cust_no' => $custNo, 'lottery_id' => $payRecord->lottery_id, 'lottery_value' => $payRecord->lottery_value]);
            if ($storeLotteryRet === false) {
                throw new Exception('库存修改失败-门店彩种');
            }
            $upMachine = Machine::updateAll($update, ['cust_no' => $custNo, 'machine_code' => $machine['machine_code'], 'terminal_num' => $machine['terminal_num']]);
            if ($upMachine === false) {
                throw new Exception('库存修改失败-机器');
            }
            $trans->commit();
            return ['code' => 600, 'msg' => '购彩成功'];
        } catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 机器服务层绑定终端号
     * @param type $terminalNum
     * @param type $machineCode
     * @return type
     */
    public static function bindingServer($terminalNum, $machineCode) {
        $url = \Yii::$app->params['machine_service'] . 'binding';
        $md5Code = $terminalNum . $machineCode;
        $sign = Commonfun::getSign($md5Code);
        $postData = ['cust_no' => $terminalNum, 'machine_no' => $machineCode, 'sign' => $sign];
        $ret = \Yii::sendCurlPost($url, $postData);
        return $ret;
    }
    
    /**
     * 终端号与机器码绑定
     * @param type $custNo
     * @param type $terminalNum
     * @param type $machineCode
     * @return type
     * @throws Exception
     */
    public static function machineUnBinding($custNo, $terminalNum, $machineCode) {
        $machine = Machine::findOne(['cust_no' => $custNo, 'terminal_num' => $terminalNum, 'machine_code' => $machineCode, 'status' => 1]);
        if(empty($machine)) {
            return ['code' => 109, 'msg' => '请确认该机器已激活'];
        }
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            $machine->status = 2;
            if(!$machine->save()) {
                throw new Exception('解绑失败-设备');
            }
            $upTerminal = Terminal::updateAll(['use_status' => 0], ['terminal_num' => $terminalNum]);
            if($upTerminal === false) {
                throw new Exception('解绑失败-终端');
            }
            $machineUnBind = self::unBindingServer($terminalNum, $machineCode);
            if($machineUnBind['code'] != 600) {
                throw new Exception($machineUnBind['msg']);
            }
            $trans->commit();
            return ['code' => 600, 'msg' => '解绑成功'];
        } catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 机器服务层解绑终端号
     * @param type $terminalNum
     * @param type $machineCode
     * @return type
     */
    public static function unBindingServer($terminalNum, $machineCode) {
        $url = \Yii::$app->params['machine_service'] . 'un_binding';
        $md5Code = $terminalNum . $machineCode;
        $sign = Commonfun::getSign($md5Code);
        $postData = ['cust_no' => $terminalNum, 'machine_no' => $machineCode, 'sign' => $sign];
        $ret = \Yii::sendCurlPost($url, $postData);
        return $ret;
    }

}
