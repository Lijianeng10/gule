<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/05/23
 * Time: 15:20:11
 */
require 'vendor/autoload.php';
use Pheanstalk\Pheanstalk;

$pheanstalk = new Pheanstalk('127.0.0.1');
print_r($pheanstalk->stats());