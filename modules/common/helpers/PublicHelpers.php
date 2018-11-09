<?php


namespace app\modules\common\helpers;

class PublicHelpers {
    /**
     * 动态广告适用类型
     */
    const BANANER_TYPE = [
        "0"=>"请选择",
        "1"=>"竞彩首页",
        "3"=>"发现界面",
        "2"=>"启动页面",
        "4"=>"PC首页",
    ];
    /**
     * 动态广告状态
     */
    const BANANER_STATUS = [
        ""=>"请选择",
        "0"=>"未发布",
        "1"=>"在线",
        "2"=>"下线",
    ];
    /**
     * 获取交易编码
     * @param string $lotteryType
     * @param char $letter
     * @return string
     */
    public static function getCode($lotteryType, $letter) {
        $time = date('ymdHis');
        $code = "GLC" . $lotteryType . $time . $letter.  rand(0,99);
        return $code;
    }
    /**
     * 生成唯一不重复的号码
     * $num 需要的位数
     */
    public static function getRandMark($num) {
        $str = strtoupper(substr(md5(uniqid(microtime(true), true)),0,$num));
        return $str;
    }
    /**
     * 动态广告使用范围
     */
    const BANANER_USE = [
        ""=>"请选择",
        "1"=>"咕啦APP",
        "2"=>"代理商界面",
    ];
    /**
     * 动态广告状态
     */
    const APPLY_STATUS = [
        ""=>"请选择",
        "0"=>"未处理",
        "1"=>"已处理",
        "2"=>"无效订单",
    ];

    /**
     * 发现界面动态广告投放区域
     */
    const BANANER_AREA = [
        ""=>"请选择",
        "1"=>"APP",
        "2"=>"PC端",
    ];
    /**
     * 发现界面动态广告投放区域
     */
    const JUMP_TYPE = [
        ""=>"请选择",
        "1"=>"跳转软文",
        "2"=>"跳转链接",
    ];
    /**
     * 接单状态
     */
    const TAKING_STATUS = [
        "0"=>"暂未接单",
        "1"=>"已接单",
        "2"=>"未接单",
    ];
    /**
     * 接单状态
     */
    const INFO_TYPE = [
        ""=>"请选择",
        "1"=>"足球资讯",
        "2"=>"篮球资讯"
    ];

}
