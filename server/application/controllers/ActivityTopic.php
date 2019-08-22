<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class ActivityTopic extends CI_Controller {
    public function index() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
    }
	
	public function add() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
        
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $name = isset($_POST['name']) ? $_POST['name'] : ' no post name';
        $logo_url = isset($_POST['logoUrl']) ? $_POST['logoUrl'] : ' no post logoUrl';        
        $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : ' no post introduction';
        $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : ' no post startDate'; 
        $start_date_init = $start_date;
        $content = isset($_POST['content']) ? $_POST['content'] : ' no post content';
        $create_time = date('Y-m-d H:i:s');
        log_message('error',"userId".$user_id);    
        log_message('error',"name".$name);   
        log_message('error',"logoUrl".$logo_url);        
        log_message('error',"introduction".$introduction);       
        log_message('error',"start_date".$start_date);             
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
            DB::insert('gActivityTopic', compact('activity_id', 'user_id', 'name','start_date','start_date_init','logo_url', 'introduction', 'content', 'create_time'));
            //$this->load->library('FffUser');
           // $id = $this->fffuser->readAcitivity($result['userinfo']['openId']);
          
            $query = DB::raw("SELECT LAST_INSERT_ID() AS lastid");  
            $id = $query->fetch(PDO::FETCH_OBJ);
            ob_start();
            var_dump($id);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();
            //log_message('error',"activity id".$id);      
            
            $this->json([
                'code' => 0,
                'data' => $id->lastid
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
            $res = DB::row('gActivityTopic', ['*'], compact('id')); 

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

    public function readAll() {
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            //$res = DB::select('gActivityTopic', ['*'], ['activity_id' => $activity_id]); 
            $sql = "SELECT * FROM gActivityTopic WHERE activity_id=".$activity_id." order by start_date desc";            
            $query = DB::raw($sql); 
            //$query = DB::raw("SELECT LAST_INSERT_ID() AS lastid");  
            $res = $query->fetchAll(PDO::FETCH_OBJ);

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
    
    public function readPreTodayAll() {
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            //$res = DB::select('gActivityTopic', ['*'], ['activity_id' => $activity_id]); 
            $sql = "SELECT * FROM gActivityTopic WHERE activity_id=".$activity_id." and start_date<=curdate() order by start_date desc";            
            $query = DB::raw($sql); 
            //$query = DB::raw("SELECT LAST_INSERT_ID() AS lastid");  
            $res = $query->fetchAll(PDO::FETCH_OBJ);

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

    public function readAllSimpleForUser() {
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::select('gActivityTopic', ['id','name','start_date'], ['activity_id' => $activity_id]); 

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

