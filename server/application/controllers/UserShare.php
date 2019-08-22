<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class UserShare extends CI_Controller {
    public function index() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $share_user_id = isset($_POST['shareUserId']) ? $_POST['shareUserId'] : ' no post shareUserId';
        $create_time = date('Y-m-d H:i:s');
        log_message('error',"user_id".$user_id);            
        log_message('error',"share_user_id".$share_user_id);            
        
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
            DB::insert('gShareUser', compact('user_id','share_user_id','create_time'));
            
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

