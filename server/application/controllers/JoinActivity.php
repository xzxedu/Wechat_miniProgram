<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class JoinActivity extends CI_Controller {
    public function index() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no userId';   
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no activityId';  
        $auth = 3;
        $create_time = date('Y-m-d H:i:s');

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::row('gActivityUser', ['*'], ['user_id'=>$user_id,'activity_id'=>$activity_id]);

            if ($res === NULL) {
              DB::insert('gActivityUser', compact('user_id', 'activity_id', 'auth', 'create_time'));
            }  
            $this->json([
                'code' => 0,
                'data' => 1
            ]);
        } else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }
    }
}

/*
        array(9) {
  ["openId"]=>
  string(28) "oMbUq5EY2TQ9Pt7mlpk4avUaxqgo"
  ["nickName"]=>
  string(5) "qiuxg"
  ["gender"]=>
  int(1)
  ["language"]=>
  string(5) "zh_CN"
  ["city"]=>
  string(8) "Dongying"
  ["province"]=>
  string(8) "Shandong"
  ["country"]=>
  string(5) "China"
  ["avatarUrl"]=>
  string(124) "https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK23CC9E7KKRZduSr3zav2qt9icicfYHCkdqb2s8UzASPze54xQyicZO2u8BjAIpIxqOcC4YyHBIYRDw/0"
  ["watermark"]=>
  array(2) {
    ["timestamp"]=>
    int(1520356124)
    ["appid"]=>
    string(18) "wx6ac26d5de9227351"
  }
}
*/
