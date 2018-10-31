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
                $url = '';
            } else {
                if ($machineData['status'] == 0) {
                    return ['code' => 109, 'msg' => '该机器已被禁用'];
                }
                if ($machineData['cust_no'] == $custNo) {
                    $url = '';
                } elseif ($machineData['cust_no'] != $custNo) {
                    $url = '';
                }
            }
        } else {
            if (empty($machineData)) {
                return ['code' => 109, 'msg' => '该机器未激活！请联系店主'];
            } elseif ($machineData['status'] == 1) {
                $url = '';
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
    public static function activeMachine($custNo, $terminalNum, $machineCode, $sellValue) {
        $terminal = Terminal::find()->select(['terminal_id'])->where(['terminal_num' => $terminalNum, 'status' => 1, 'user_status' => 1])->asArray()->one();
        if (empty($terminal)) {
            return ['code' => 109, 'msg' => '此终端码已被禁用'];
        }
        $machineData = Machine::find()->select(['cust_no', 'machine_code', 'terminal_num'])->where(['terminal_num' => $terminalNum, 'status' => 1])->asArray()->one();
        if ($machineData) {
            return ['code' => 109, 'msg' => '该终端码已被激活绑定'];
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
            if ($storeData['code'] != 0) {
                return ['code' => 109, 'msg' => $storeData['msg']];
            }
            $store->cust_no = $custNo;
            $store->channel_no = $storeData['channel_no'];
            $store->user_tel = $storeData['user_tel'];
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
            $machine->lottery_value = $sellValue;
            $machine->ac_status = 1;
            $machine->online_status = 1;
            $machine->create_time = date('Y-m-d H:i:s');
            if(!$machine->save()) {
                throw new Exception('激活失败！');
            }
            $store->status = 1;
            if(!$store->save()) {
                throw new Exception('门店绑定激活失败！');
            }
            $trans->commit();
            return ['code' => 600, 'msg' => '激活成功'];
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
        $url = \Yii::$app->params['validate_machine'];
        $sign = Commonfun::getSign($machineCode);
        $postData = ['machine' => $machineCode, 'sign' => $sign];
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
            if(array_key_exists($lottery['lottery_value'], $lotteryValue)) {
                if(!array_key_exists($lottery['lottery_id'], $lotteryValue['lottery'])){
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
    
    

}
