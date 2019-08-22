<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class ActivityFollow extends CI_Controller {
    public function index() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
    }
	
	public function add() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
        
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : 'no post activityId';
        $topic_id = isset($_POST['topicId']) ? $_POST['topicId'] : 'no post topicId';
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : 'no post userId';
        $note = isset($_POST['note']) ? $_POST['note'] : 'no post note';        
        $content = isset($_POST['content']) ? $_POST['content'] : 'no post content';
        $answer = isset($_POST['answer']) ? $_POST['answer'] : 'no post answer';
        $create_time = date('Y-m-d H:i:s');
        log_message('error',"userId".$user_id);    
        log_message('error',"activity_id".$activity_id);   
        log_message('error',"topic_id".$topic_id); 
        log_message('error',"note".$note);            
        log_message('error',"answer".$answer);   

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
            DB::insert('gActivityFollow', compact('activity_id', 'topic_id','user_id','note', 'content', 'answer','create_time'));
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

    public function edit() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';
        
        $id = isset($_POST['followId']) ? $_POST['followId'] : ' no post followId';
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';
        $topic_id = isset($_POST['topicId']) ? $_POST['topicId'] : ' no post topicId';
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $note = isset($_POST['note']) ? $_POST['note'] : ' no post note';        
        $content = isset($_POST['content']) ? $_POST['content'] : ' no post content';
        $update_time = date('Y-m-d H:i:s');
        log_message('error',"userId".$user_id);    
        log_message('error',"activity_id".$activity_id);   
        log_message('error',"topic_id".$topic_id); 
        log_message('error',"note".$note);            
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
            DB::update(
                'gActivityFollow',
                compact('note','content','update_time'),
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

    public function read() {        
        $id = isset($_POST['id']) ? $_POST['id'] : ' no post id';      

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::row('gActivityFollow', ['*'], compact('id')); 

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

    //读取某topic的跟读
    public function readTopicFollow() {        
        $topic_id = isset($_POST['topicId']) ? $_POST['topicId'] : ' no post topicId';      

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::select('gActivityFollow', ['*'], ['topic_id' => $topic_id]); 

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

    //读取用户的跟读
    public function readUserTopicFollow() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';  
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';    
        log_message('error',"userId".$user_id);    
        log_message('error',"activity_id".$activity_id);   

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::select('gActivityFollow', ['*'], ['user_id' => $user_id,'activity_id' => $activity_id]); 

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

    //读取用户的跟读次数
    public function readUserTopicFollowCount() {        
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';  
        $activity_id = isset($_POST['activityId']) ? $_POST['activityId'] : ' no post activityId';    
        log_message('error',"userId".$user_id);    
        log_message('error',"activity_id".$activity_id);   

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
          $query = DB::raw("SELECT count(*) as followDay from gActivityFollow where  user_id=".$user_id." and activity_id=".$activity_id." ");  
            $id = $query->fetch(PDO::FETCH_OBJ);
            ob_start();
            var_dump($id);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();
            //log_message('error',"activity id".$id);      
            
            $this->json([
                'code' => 0,
                'data' => $id->followDay
            ]);            
        } else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }
    }

    //删除跟读
    public function del() {        
        $id = isset($_POST['followId']) ? $_POST['followId'] : ' no post id';
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';

        log_message('error',"del".$id);

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            $res = DB::delete('gActivityFollow',compact('id')); 
            
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

