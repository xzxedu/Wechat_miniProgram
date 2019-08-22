<?php
defined('BASEPATH') or exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class WebLogin extends CI_Controller
{
    public function index()
    {

        /*ob_start();
        var_dump($_POST);
        $content = ob_get_contents();
        log_message('error',$content);
        ob_end_clean();*/

        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $password = isset($_POST['password']) ? $_POST['password'] : ' no post password';

        log_message('error', "user_id" . $user_id);
        log_message('error', "password" . $password);

        $res = DB::row('gAdmin', ['*'], compact('user_id'));

        log_message('error', "user password" . $res->password);

        //if ($res === null) {
        if ($password === $res->password) {
            session_start();
            $_SESSION['user_id'] = $res->user_id;
            $this->json([
                'code' => 0
            ]);
           
        } else {
            $this->json([
                'code' => -1
            ]);            
        }
        //echo "123";feadmin123

    }
}

/*
array(2) {
["userinfo"]=>
object(stdClass)#15 (9) {
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
object(stdClass)#16 (2) {
["timestamp"]=>
int(1520577246)
["appid"]=>
string(18) "wx6ac26d5de9227351"
}
}
["skey"]=>
string(40) "25f801c1f205f32b0816f0d5fe48399de6022ec6"
}
 */
