<?php
defined('BASEPATH') or exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class WebPartner extends CI_Controller
{
    public function index()
    {

        /*ob_start();
        var_dump($_POST);
        $content = ob_get_contents();
        log_message('error',$content);
        ob_end_clean();*/
		session_start();	
		
		$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ' no post userId';       

        log_message('error', "user_id" . $user_id);
        
        //加入的活动
        //$sql = "SELECT * FROM gActivity WHERE  id IN (SELECT  activity_id FROM gActivityUser WHERE user_id=".$user_id.")";
        
        $sql = "SELECT * FROM gPartner WHERE  user_id=".$user_id;

        $query = DB::raw($sql); 
         
        $res = $query->fetchAll(PDO::FETCH_OBJ);

        if ($res === NULL) {
            $res = [];
        } 
            
        $this->json([
            'code' => 0,
            'data' => $res
        ]);        
        //echo "123";feadmin123
    }

    public function add() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';

        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $name = isset($_POST['name']) ? $_POST['name'] : ' no post name';
        $logo_url = isset($_POST['logoUrl']) ? $_POST['logoUrl'] : ' no post logoUrl';
        $logo_v_url = isset($_POST['logoVUrl']) ? $_POST['logoVUrl'] : ' no post logoVUrl';
        $tagline = isset($_POST['tagline']) ? $_POST['tagline'] : ' no post tagline';        
        $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : ' no post introduction';
        $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : ' no post startDate';
        $end_date = isset($_POST['endDate']) ? $_POST['endDate'] : ' no post endDate';
        $user_num_limit = isset($_POST['userNumLimit']) ? $_POST['userNumLimit'] : ' no post num';  
        $content = isset($_POST['content']) ? $_POST['content'] : ' no post content';
        $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
        $create_time = date('Y-m-d H:i:s');
        log_message('error',"userId".$user_id);    
        log_message('error',"name".$name);   
        log_message('error',"logoUrl".$logo_url); 
        log_message('error',"logoVUrl".$logo_v_url); 
        log_message('error',"tagline".$tagline);       
        log_message('error',"introduction".$introduction);       
        log_message('error',"start_date".$start_date);    
        log_message('error',"end_date".$end_date);             
        log_message('error',"user_num_limit".$user_num_limit);       
        log_message('error',"content".$content);
        log_message('error',"group_id".$group_id);      

        /*
        ob_start();
        var_dump($content);
        $r = ob_get_contents();
        log_message('error',$r);
        ob_end_clean();*/
        

        //if ($result['loginState'] === Constants::S_AUTH) {
            DB::insert('gPartner', compact('user_id', 'name','logo_url','logo_v_url','tagline', 'introduction', 'start_date','end_date', 'user_num_limit', 'content', 'group_id', 'create_time'));
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
            $activity_id = $id->lastid;
            $auth = 1;

            //创建成功后自动加入  
            //DB::insert('gActivityUser', compact('user_id', 'activity_id', 'auth', 'create_time'));
            
            $this->json([
                'code' => 0,
                'data' => $activity_id
            ]);
        /*} else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }*/
    }

    public function update() {
        //$method = isset($_POST['method']) ? $_POST['method'] : ' no post';
        //$method = isset($_GET['method']) ? $this->input->get('method') : 'get';

        $id = isset($_POST['id']) ? $_POST['id'] : ' no post id';
        $user_id = isset($_POST['userId']) ? $_POST['userId'] : ' no post userId';
        $name = isset($_POST['name']) ? $_POST['name'] : ' no post name';
        $logo_url = isset($_POST['logoUrl']) ? $_POST['logoUrl'] : ' no post logoUrl';
        $logo_v_url = isset($_POST['logoVUrl']) ? $_POST['logoVUrl'] : ' no post logoVUrl';
        $tagline = isset($_POST['tagline']) ? $_POST['tagline'] : ' no post tagline';        
        $introduction = isset($_POST['introduction']) ? $_POST['introduction'] : ' no post introduction';
        $start_date = isset($_POST['startDate']) ? $_POST['startDate'] : ' no post startDate';
        $end_date = isset($_POST['endDate']) ? $_POST['endDate'] : ' no post endDate';
        $user_num_limit = isset($_POST['userNumLimit']) ? $_POST['userNumLimit'] : ' no post num';  
        $content = isset($_POST['content']) ? $_POST['content'] : ' no post content';
        $group_id = isset($_POST['group_id']) ? $_POST['group_id'] : '';
        
        log_message('error',"id".$id); 
        log_message('error',"userId".$user_id);    
        log_message('error',"name".$name);   
        log_message('error',"logoUrl".$logo_url); 
        log_message('error',"logoVUrl".$logo_v_url);
        log_message('error',"tagline".$tagline);       
        log_message('error',"introduction".$introduction);       
        log_message('error',"start_date".$start_date);    
        log_message('error',"end_date".$end_date);             
        log_message('error',"user_num_limit".$user_num_limit);       
        log_message('error',"content".$content);   
        log_message('error',"group_id".$group_id);

        /*
        ob_start();
        var_dump($content);
        $r = ob_get_contents();
        log_message('error',$r);
        ob_end_clean();*/
        
        $res = DB::update('gPartner', compact('user_id', 'name','logo_url','logo_v_url','tagline', 'introduction', 'start_date','end_date', 'user_num_limit', 'content', 'group_id'),compact('id'));
        log_message('error',"res".$res);   
        $this->json([
            'code' => 0                
        ]);
        
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
