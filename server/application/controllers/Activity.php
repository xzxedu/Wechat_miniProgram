<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Activity extends CI_Controller {
    public function index() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';

        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $name = isset($_POST['name']) ? $_POST['name'] : ' no post name';
        $logo_url = isset($_POST['logoUrl']) ? $_POST['logoUrl'] : ' no post logoUrl';
        $tagline = isset($_POST['tagline']) ? $_POST['tagline'] : ' no post tagline';        
        $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : ' no post introduction';
        $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : ' no post startDate';
        $end_date = isset($_POST['endDate']) ? $_POST['endDate'] : ' no post endDate';
        $user_num_limit = isset($_POST['userNumLimit']) ? $_POST['userNumLimit'] : ' no post num';  
        $content = isset($_POST['content']) ? $_POST['content'] : ' no post content';
        $create_time = date('Y-m-d H:i:s');
        
    }
	
	  public function activityUserNum() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';

        //$activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post userId';
        
        //log_message('error',"activityId".$activity_id);    
        
        $result = LoginService::check();           

        if ($result['loginState'] === Constants::S_AUTH) {          
            $query = DB::raw("SELECT activity_id,COUNT(user_id) AS user_num FROM gActivityUser  GROUP BY activity_id;");  
            $activityUserNum = $query->fetchAll(PDO::FETCH_OBJ);
            ob_start();
            var_dump($activityUserNum);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();
            //log_message('error',"activity id".$id);  

            if ($activityUserNum === NULL) {
                $activityUserNum = [];
            } 
                       
            $this->json([
                'code' => 0,
                'data' => $activityUserNum
            ]);
        } else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }
    }

    	  public function activityFollowNum() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';

        //$activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post userId';
        
        //log_message('error',"activityId".$activity_id);    
        
        $result = LoginService::check();           

        if ($result['loginState'] === Constants::S_AUTH) {          
            $query = DB::raw("SELECT activity_id,COUNT(user_id) AS user_num FROM gActivityFollow  GROUP BY activity_id;");  
            $activityFollowNum = $query->fetchAll(PDO::FETCH_OBJ);
            ob_start();
            var_dump($activityFollowNum);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();
            //log_message('error',"activity id".$id);  

            if ($activityFollowNum === NULL) {
                $activityFollowNum = [];
            } 
                       
            $this->json([
                'code' => 0,
                'data' => $activityFollowNum
            ]);
        } else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }
    }

    public function hide() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
        
        $id  = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';

        $state = 2;
        
        log_message('error',"userId".$user_id);    
        log_message('error',"activity_id".$id);   
        
        $result = LoginService::check();        

        /*
        ob_start();
        var_dump($content);
        $r = ob_get_contents();
        log_message('error',$r);
        ob_end_clean();*/
        

        if ($result['loginState'] === Constants::S_AUTH) {
            DB::update(
                'gActivity',
                compact('state'),
                compact('id') 
                );                  
            
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

    public function show() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
        
        $id  = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';

        $state = 1;
        
        log_message('error',"userId".$user_id);    
        log_message('error',"activity_id".$id);   
        
        $result = LoginService::check();        

        /*
        ob_start();
        var_dump($content);
        $r = ob_get_contents();
        log_message('error',$r);
        ob_end_clean();*/
        

        if ($result['loginState'] === Constants::S_AUTH) {
            DB::update(
                'gActivity',
                compact('state'),
                compact('id') 
                );                  
            
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

    public function readHideActivity() {        
        $id = isset($_POST['page']) ? $_POST['page'] : '1';      

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            //$res = DB::row('gActivity', ['*'], compact('id')); 
            $res = DB::select('gActivity', ['*'], ['state' => 2]); 

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

