<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class Relation extends CI_Controller {
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
	
	  public function add() {
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $follow_user_id = isset($_POST['followUserId']) ? $_POST['followUserId'] : ' no post followUserId';
        $create_time = date('Y-m-d H:i:s');
        
        $result = LoginService::check();           

        if ($result['loginState'] === Constants::S_AUTH) {          
            DB::insert('gRelation', compact('user_id','follow_user_id', 'create_time'));
            //$this->load->library('FffUser');
           // $id = $this->fffuser->readAcitivity($result['userinfo']['openId']);

            log_message('error',"add relation"); 
          
            $query = DB::raw("SELECT LAST_INSERT_ID() AS lastid");  
            $id = $query->fetch(PDO::FETCH_OBJ);
            /*ob_start();
            var_dump($id);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();*/
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

    public function del() {
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $follow_user_id = isset($_POST['followUserId']) ? $_POST['followUserId'] : ' no post followUserId';

        $result = LoginService::check();           

        if ($result['loginState'] === Constants::S_AUTH) {          
            DB::delete('gRelation', compact('user_id','follow_user_id'));            

            log_message('error',"del relation"); 
          
            
            /*ob_start();
            var_dump($id);
            $r = ob_get_contents();
            log_message('error',$r);
            ob_end_clean();*/
            //log_message('error',"activity id".$id);      
            
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

    public function readUserFollowing() {
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';         
        $result = LoginService::check();           

        if ($result['loginState'] === Constants::S_AUTH) {          
            $res = DB::select('gRelation', ['*'], ['user_id' => $user_id]); 

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

