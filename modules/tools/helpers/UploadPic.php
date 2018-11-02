<?php

namespace app\modules\tools\helpers;

class UploadPic {

    /**
     * 说明: 上传文件至图片服务器
     * @author  kevi
     * @date 2017年7月6日 下午1:35:51
     * @param $file
     * @return $saveDir
     */
    public static function pic_host_upload($file, $saveDir, $name = '') {
        header('content-type:text/html;charset=utf8');
        $ch = curl_init();
        $url = \Yii::$app->params["lottery_img_host"];
        //加@符号curl就会把它当成是文件上传处理
        $value = new \CURLFile($file['tmp_name']);
        $data = [
            'name' => rand(0, 20),
            'save_dir' => $saveDir,
            'img' => $value,
            'type' => 1
        ];
        if ($name) {
            $data['name'] = $name;
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 上传图片到图片服务器
     * @author GL zyl
     * @param img $file
     * @param string $saveDir
     * @param string $name
     * @return $saveDir
     */
    public static function pic_host_upload_base64($file, $saveDir, $name) {
        header('content-type:text/html;charset=utf8');
        $ch = curl_init();
        $url = \Yii::$app->params["lottery_img_host"];
        //加@符号curl就会把它当成是文件上传处理
        $data = [
            'name' => $name,
            'save_dir' => $saveDir,
            'file' => $file,
            'type' => 2
        ];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 图片上传格式判断
     * @auther GL zyl
     * @param type $file
     * @return string|int
     */
    public static function check_upload_pic($file) {
        $typeArr = array('gif', 'jpg', 'jpeg', 'png');
        $result = [];
        if ($file['name']) {
            $name = $file['name'];
            $type = strtolower(substr($name, strrpos($name, '.') + 1));
            if (!in_array($type, $typeArr)) {
                $result = ['code' => 440, 'msg' => '文件格式不正确'];
                return $result;
            }
//            $result = ['code'=>600];
//            return $result;
        } else {
            $result = ['code' => 441, 'msg' => '上传文件未找到'];
            return $result;
        }
        if ($file['size']) {
            $size = $file['size'];
            if ($size > 1024 * 1024) {
                $result = ['code' => 441, 'msg' => '请上传大小小于1024K的图片'];
                return $result;
            }
        }
        $result = ['code' => 600];
        return $result;
    }

    /**
     * 上传图片到图片服务器
     * @param img $file
     * @param string $saveDir
     * @param string $name
     * @return $saveDir
     */
    public static function sysUploadImg($file, $saveDir, $name) {
        header('content-type:text/html;charset=utf8');
        $ch = curl_init();
        $url = \Yii::$app->params["lottery_img_host"];
        //加@符号curl就会把它当成是文件上传处理
        $value = new \CURLFile($file);
        $data = [
            'name' => $name,
            'save_dir' => $saveDir,
            'img' => $value,
            'type' => 1
        ];
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
