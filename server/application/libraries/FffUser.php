<?php

use QCloud_WeApp_SDK\Mysql\Mysql as DB;
use QCloud_WeApp_SDK\Constants;
//use \Exception;
//用了Exception后，显示Warning:  The use statement with non-compound name 'Exception' has no effect in /data/release/php-weapp-demo/application/libraries/FffUser.php"

class Fffuser
{
    public static function storeUserInfo ($userinfo) {
      //log_message('error','storeUserInfo');
      /*
        $uuid = bin2hex(openssl_random_pseudo_bytes(16));
        $create_time = date('Y-m-d H:i:s');
        $last_visit_time = $create_time;
        $open_id = $userinfo->openId;
        $user_info = json_encode($userinfo);

        $res = DB::row('cSessionInfo', ['*'], compact('open_id'));
        if ($res === NULL) {
            DB::insert('cSessionInfo', compact('uuid', 'skey', 'create_time', 'last_visit_time', 'open_id', 'session_key', 'user_info'));
        } else {
            DB::update(
                'cSessionInfo',
                compact('uuid', 'skey', 'last_visit_time', 'session_key', 'user_info'),
                compact('open_id')
            );
        }*/

        $open_id = $userinfo['openId'];
        $wx_nick_name = $userinfo['nickName'];
        $nick_name = $userinfo['nickName'];
        $gender = $userinfo['gender'];
        $language = $userinfo['language'];
        $city = $userinfo['city'];
        $province = $userinfo['province'];
        $country = $userinfo['country'];
        $avatar_url = $userinfo['avatarUrl'];
        //$tel = "";
        //$auth = 1;
        $create_time = date('Y-m-d H:i:s');

        $res = DB::row('gUser', ['*'], compact('open_id'));
        
        /*
        ob_start();
        var_dump($res);
        $content = ob_get_contents();
        log_message('error',$content);
        ob_end_clean();*/

        if ($res === NULL) {
            //DB::insert('gUser', compact('open_id', 'wx_nick_name','nick_name','gender','language', 'city', 'province','country', 'avatar_url', 'tel', 'auth', 'create_time'));
            DB::insert('gUser', compact('open_id', 'wx_nick_name','nick_name','gender','language', 'city', 'province','country', 'avatar_url', 'tel', 'create_time'));
        } else {
            //DB::update(
            //    'gUser',
            //    compact('wx_nick_name', 'nick_name', 'avatar_url', 'tel', 'auth'),
            //    compact('open_id')
            //);
            DB::update(
                'gUser',
                compact('wx_nick_name', 'nick_name', 'avatar_url'),
                compact('open_id')
            );
        }
        //return "123";            
    }

    /*public static function findUserBySKey ($skey) {
        return DB::row('cSessionInfo', ['*'], compact('skey'));
    }*/

    public static function readUser($open_id){
        $res = DB::row('gUser', ['*'], compact('open_id'));
        
        /*
        ob_start();
        var_dump($res);
        $content = ob_get_contents();
        log_message('error',$content);
        ob_end_clean();*/

        if ($res === NULL) {
            return NULL;
        } else {
            //return $res->id;
            return $res;
        }
    }
}


/*db.row
object(stdClass)#18 (13) {
  ["id"]=>
  string(1) "1"
  ["open_id"]=>
  string(28) "oMbUq5EY2TQ9Pt7mlpk4avUaxqgo"
  ["wx_nick_name"]=>
  string(5) "qiuxg"
  ["nick_name"]=>
  string(5) "qiuxg"
  ["gender"]=>
  string(1) "1"
  ["language"]=>
  string(5) "zh_CN"
  ["city"]=>
  string(8) "Dongying"
  ["province"]=>
  string(8) "Shandong"
  ["country"]=>
  string(5) "China"
  ["avatar_url"]=>
  string(124) "https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTK23CC9E7KKRZduSr3zav2qt9icicfYHCkdqb2s8UzASPze54xQyicZO2u8BjAIpIxqOcC4YyHBIYRDw/0"
  ["tel"]=>
  string(0) ""
  ["auth"]=>
  string(1) "1"
  ["create_time"]=>
  string(19) "2018-03-07 01:27:16"
}
*/