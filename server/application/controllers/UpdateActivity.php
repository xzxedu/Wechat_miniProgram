<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class UpdateActivity extends CI_Controller {
    public function index() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';

        $id = isset($_POST['id']) ? $_POST['id'] : ' no post id';
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $name = isset($_POST['name']) ? $_POST['name'] : ' no post name';
        $logo_url = isset($_POST['logoUrl']) ? $_POST['logoUrl'] : ' no post logoUrl';
        //$tagline = isset($_POST['tagline']) ? $_POST['tagline'] : ' no post tagline';        
        $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : ' no post introduction';
        $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : ' no post startDate';
        $end_date = isset($_POST['endDate']) ? $_POST['endDate'] : ' no post endDate';
        $user_num_limit = isset($_POST['userNumLimit']) ? $_POST['userNumLimit'] : ' no post num';  
        $content = isset($_POST['content']) ? $_POST['content'] : ' no post content';
        $group_id = isset($_POST['groupId']) ? $_POST['groupId'] : ' no post groupId';
        $addr = isset($_POST['addr']) ? $_POST['addr'] : ' no post addr';        
        $create_time = date('Y-m-d H:i:s');
        log_message('error',"userId".$user_id);    
        log_message('error',"name".$name);   
        log_message('error',"logoUrl".$logo_url); 
        log_message('error',"introduction".$introduction);       
        log_message('error',"start_date".$start_date);    
        log_message('error',"end_date".$end_date);             
        log_message('error',"user_num_limit".$user_num_limit);       
        log_message('error',"content".$content);   

        //$start_date =  date("Y-m-d",$start_date); 
        //$end_date =  date("Y-m-d",$end_date); 

        $result = LoginService::check();        

        /*
        ob_start();
        var_dump($content);
        $r = ob_get_contents();
        log_message('error',$r);
        ob_end_clean();*/
        

        if ($result['loginState'] === Constants::S_AUTH) {
           $res = DB::update('gActivity', compact('user_id', 'name','logo_url','introduction', 'start_date','end_date', 'user_num_limit', 'content', 'group_id','addr'),compact('id'));
           log_message('error',"res".$res);
            $this->json([
                'code' => 0
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
