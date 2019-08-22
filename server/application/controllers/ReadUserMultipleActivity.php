<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class ReadUserMultipleActivity extends CI_Controller {
    public function index() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : '1';      

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            //$res = DB::row('gActivity', ['*'], compact('id')); 
            $queryUserActivity = DB::raw("SELECT * FROM gActivity WHERE id IN (SELECT activity_id FROM gActivityUser WHERE user_id = ".$user_id.")");

            $res = $queryUserActivity->fetchAll(PDO::FETCH_OBJ); 

            if ($res === NULL) {
                $res = [];
            }

            $query = DB::raw("SELECT id,nick_name,avatar_url FROM gUser WHERE id IN (SELECT DISTINCT user_id FROM gActivity WHERE state=1)"); 
             
            $resActivityUser = $query->fetchAll(PDO::FETCH_OBJ);

            if ($resActivityUser === NULL) {
                $resActivityUser = [];
            }


            /*if ($res === NULL) {
                $res = [];
            }*/

            /*
            $resTag = DB::select('gTag', ['*'],[]);             

            if ($resTag === NULL) {
                $resTag = [];
            }

            $resGrade = DB::select('gGrade', ['*'],[]);             

            if ($resGrade === NULL) {
                $resGrade = [];
            }            

            $resActivityTag = DB::select('gActivityTag', ['*'],[]);             

            if ($resActivityTag === NULL) {
                $resActivityTag = [];
            }

            $resActivityGrade = DB::select('gActivityGrade', ['*'],[]);             

            if ($resActivityGrade === NULL) {
                $resActivityGrade = [];
            }

            $resActivityLevel = DB::select('gActivityLevel', ['*'],[]);             

            if ($resActivityLevel === NULL) {
                $resActivityLevel = [];
            }*/

            /* $query = DB::raw("SELECT id,name,is_hide FROM gSubject WHERE is_show=1 ORDER BY sort_value"); 
             
            $resSubject = $query->fetchAll(PDO::FETCH_OBJ);

            if ($resSubject === NULL) {
                $resSubject = [];
            } 

            $resActivitySubject = DB::select('gActivitySubject', ['*'],[]);             

            if ($resActivitySubject === NULL) {
                $resActivitySubject = [];
            } */

            //分组
            // $group = array(1=>"跟读",2=>"阅读",3=>"同步课程",4=>"听力",5=>"口语",6=>"免费");
            
            $this->json([
                'code' => 0,
                'data' => $res,
                'activityUser' => $resActivityUser
                //'group' => $group,
                //tag'=> $resTag,
                //'grade'=> $resGrade,
                //'subject'=> $resSubject,
                //'activitySubject'=>$resActivitySubject
                //'activityTag'=> $resActivityTag,
                //'activityGrade'=> $resActivityGrade,
                //'activityLevel'=> $resActivityLevel
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
