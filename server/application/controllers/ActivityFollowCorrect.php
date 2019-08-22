<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class ActivityFollowCorrect extends CI_Controller {
    public function index() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
    }
	
	public function add() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
        
        $follow_id = isset($_POST['followId']) ? $_POST['followId'] : ' no post followId';      
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $review = isset($_POST['review']) ? $_POST['review'] : ' no post review';  
        $record_url = isset($_POST['correctRecordUrl']) ? $_POST['correctRecordUrl'] : '';   
        $img_url = isset($_POST['correctImgUrl']) ? $_POST['correctImgUrl'] : ''; 
          
        $create_time = date('Y-m-d H:i:s');
        log_message('error',"userId".$user_id);    
        log_message('error',"follow_id".$follow_id);       
        log_message('error',"review".$review);   

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
            DB::insert('gActivityFollowCorrect', compact('follow_id', 'user_id','review', 'record_url', 'img_url', 'create_time'));
            //$this->load->library('FffUser');
           // $id = $this->fffuser->readAcitivity($result['userinfo']['openId']);
          
            $query = DB::raw("SELECT LAST_INSERT_ID() AS lastid");  
            $id_obj = $query->fetch(PDO::FETCH_OBJ);
            ob_start();
            var_dump($id_obj);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();
            //log_message('error',"activity id".$id);      
            
            //$this->json([
            //    'code' => 0,
            //    'data' => $id_obj->lastid
            //]);

            $id = $id_obj->lastid;

            $res = DB::row('gActivityFollowCorrect', ['*'], compact('id')); 

            if ($res === NULL) {
                $res = [];
            } 

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

    public function read() {        
        $id = isset($_POST['id']) ? $_POST['id'] : ' no post id';      

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::row('gActivityFollowCorrect', ['*'], compact('id')); 

            if ($res === NULL) {
                $res = [];
            } 
            
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
    
    public function readFollowCorrect() {        
        $follow_id = isset($_POST['followId']) ? $_POST['followId'] : ' no post followId';   
        log_message('error',"readFollowCorrect follow_id".$follow_id);   

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {            
            $res = DB::select('gActivityFollowCorrect', ['*'], ['follow_id' => $follow_id]); 

            if ($res === NULL) {
                $res = [];
            } 
            
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


}

