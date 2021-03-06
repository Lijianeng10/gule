<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\common\helpers;

class CompetConst {
    
    /**
     * 篮球赛程投注玩法
     */
    
    const LAN_SCHEDULE_PLAY = [
        '3001' => 'schedule_sf',
        '3002' => 'schedule_rfsf',
        '3003' => 'schedule_sfc',
        '3004' => 'schedule_dxf'
    ];
    
    //定制竞彩篮球
    const MADE_BASKETBALL_LOTTERY = [
        '0' => '3001',
        '1' => '3002',
        '2' => '3003',
        '3' => '3004',
        '4' => '3005'
    ];
    
    //胜分差 实际名
    const SFC_BETWEEN_ARR = [
        '01' => '主胜 1-5',
        '02' => '主胜 6-10',
        '03' => '主胜 11-15',
        '04' => '主胜 16-20',
        '05' => '主胜 21-25',
        '06' => '主胜 26+',
        '11' => '客胜 1-5',
        '12' => '客胜 6-10',
        '13' => '客胜 11-15',
        '14' => '客胜 16-20',
        '15' => '客胜 21-25',
        '16' => '客胜 26+'
    ];
    
    //竞彩组合过关
    const M_CHUAN_N =[
        '4' => '2',
        '5' => '2,3',
        '7' => '3',
        '8' => '3,6',
        '9' => '2',
        '10' => '2,3,6',
        '12' => '6',
        '13' => '6,11',
        '14' => '2',
        '15' => '3,6,11',
        '16' => '2,3',
        '17' => '2,3,6,11',
        '19' => '11',
        '20' => '11,18',
        '21' => '2',
        '22' => '3',
        '23' => '6,11,18',
        '24' => '2,3',
        '25' => '3,6,11,18',
        '26' => '2,3,6',
        '27' => '2,3,6,11,18',
        '29' => '18',
        '30' => '18,28',
        '31' => '11',
        '32' => '6',
        '33' => '2,3,6,11,18,28',
        '36' => '28',
        '37' => '28,35',
        '38' => '18',
        '39' => '11',
        '40' => '6',
        '41' => '2,3,6,11,18,28,35',
    ];
    
    //奖金优化的方式
    const MAJOR_ARR = [0 => '无优化', 1 => '平均优化', 2 => '博热优化', 3 => '博冷优化'];
    
   //玩法对应投注内容名
    const SCHEDULE_PLAY = [
        '3001' => ['0' => '负', '3' => '胜'],
        '3002' => ['0' => '【让分】负', '3' => '【让分】胜'],
        '3003' => ['01' => '主胜 1-5', '02' => '主胜 6-10', '03' => '主胜 11-15', '04' => '主胜 16-20', '05' => '主胜 21-25', '06' => '主胜 26+', '11' => '客胜 1-5', '12' => '客胜 6-10', '13' => '客胜 11-15',
                   '14' => '客胜 16-20', '15' => '客胜 21-25', '16' => '客胜 26+'],
        '3004' => ['1' => '大分', '2' => '小分'],
        '3006' => ['0' => '【让球】负', '1' => '【让球】平', '3' => '【让球】胜'],
        '3007' => ['10' => '1:0', '20' => '2:0', '21' => '2:1', '30' => '3:0', '31' => '3:1', '32' => '3:2', '40' => '4:0', '41' => '4:1', '42' => '4:2', '50' => '5:0', '51' => '5:1', '52' => '5:2','90' => '胜其他',
                   '00' => '0:0', '11' => '1:1', '22' => '2:2', '33' => '3:3', '99' => '平其他',
                   '01' => '0:1', '02' => '0:2', '12' => '1:2', '03' => '0:3', '13' => '1:3', '23' => '2:3', '04' => '0:4', '14' => '1:4', '24' => '2:4', '05' => '0:5', '15' => '1:5', '25' => '2:5', '09' => '负其他'],
        '3008' => ['0' => '0球', '1' => '1球', '2' => '2球', '3' => '3球', '4' => '4球', '5' => '5球', '6' => '6球', '7' => '7+球',],
        '3009' => ['33' => '胜胜', '31' => '胜平', '30' => '胜负', '13' => '平胜', '11' => '平平', '10' => '平负', '03' => '负胜', '01' => '负平', '00' => "负负"],
        '3010' => ['0' => '负', '1' => '平', '3' => '胜'],
        '5001' => ['0' => '负', '1' => '平', '3' => '胜'],
        '5002' => ['0' => '0球', '1' => '1球', '2' => '2球', '3' => '3球', '4' => '4球', '5' => '5球', '6' => '6球', '7' => '7+球'],
        '5003' => ['33' => '胜胜', '31' => '胜平', '30' => '胜负', '13' => '平胜', '11' => '平平', '10' => '平负', '03' => '负胜', '01' => '负平', '00' => "负负"],
        '5004' => ['1' => '上单', '2' => '上双', '3' => '下单', '4' => '下双'],
        '5005' => ['10' => '1:0', '20' => '2:0', '21' => '2:1', '30' => '3:0', '31' => '3:1', '32' => '3:2', '40' => '4:0', '41' => '4:1', '42' => '4:2', '90' => '胜其他',
                   '00' => '0:0', '11' => '1:1', '22' => '2:2', '33' => '3:3', '99' => '平其他',
                   '01' => '0:1', '02' => '0:2', '12' => '1:2', '03' => '0:3', '13' => '1:3', '23' => '2:3', '04' => '0:4', '14' => '1:4', '24' => '2:4', '09' => '负其他'],
        '5006' => ['0' => '负', '3' => '胜'],
    ];
}
