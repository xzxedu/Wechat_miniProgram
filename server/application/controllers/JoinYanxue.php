<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class JoinYanxue extends CI_Controller {
    public function index() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no userId';   
        $yanxue_id = isset($_POST['yanxueId']) ? $_POST['yanxueId'] : ' no yanxueId';
        $user_name = isset($_POST['userName']) ? $_POST['userName'] : ' no userName';  
        $nick_name = isset($_POST['nickName']) ? $_POST['nickName'] : ' no nickName';
        $age = isset($_POST['age']) ? $_POST['age'] : ' no age';
        $tel = isset($_POST['tel']) ? $_POST['tel'] : ' no tel';
        
        $create_time = date('Y-m-d H:i:s');

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::row('gYanxueUser', ['*'], ['user_id'=>$user_id,'yanxue_id'=>$yanxue_id]);

            if ($res === NULL) {
              DB::insert('gYanxueUser', compact('user_id', 'yanxue_id', 'user_name', 'nick_name', 'age', 'tel', 'create_time'));
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
    
    public function readYanxue() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no userId';   
        $yanxue_id = isset($_POST['yanxueId']) ? $_POST['yanxueId'] : ' no yanxueId';
        

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::row('gYanxueUser', ['*'], ['user_id'=>$user_id,'yanxue_id'=>$yanxue_id]);

            $this->json([
                'code' => 0,
                'data' => $res 
            ]);
        } else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }
    }

    
    public function update() {
        $id = isset($_POST['id']) ? $_POST['id'] : 'id';        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no userId';   
        $yanxue_id = isset($_POST['yanxueId']) ? $_POST['yanxueId'] : ' no yanxueId';
        $user_name = isset($_POST['userName']) ? $_POST['userName'] : ' no userName';  
        $nick_name = isset($_POST['nickName']) ? $_POST['nickName'] : ' no nickName';
        $age = isset($_POST['age']) ? $_POST['age'] : ' no age';
        $tel = isset($_POST['tel']) ? $_POST['tel'] : ' no tel';
        
        $create_time = date('Y-m-d H:i:s');

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::update('gYanxueUser', compact('user_name','age','tel'),compact('id'));
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
