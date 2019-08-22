<?php
defined('BASEPATH') or exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;
class ActivityDate extends CI_Controller 
{
    public function index()
    {

        /*ob_start();
        var_dump($_POST);
        $content = ob_get_contents();
        log_message('error',$content);
        ob_end_clean();*/
		
	      //$user_id = 1;       

        //log_message('error', "user_id" . $user_id);
        
        //加入的活动
        //$sql = "SELECT * FROM gActivity WHERE  id IN (SELECT  activity_id FROM gActivityUser WHERE user_id=".$user_id.")";
        
        $sql = "UPDATE gActivityTopic SET start_date=CURDATE() WHERE DATEDIFF(CURDATE(),start_date)=76 AND activity_id=46";

        $query = DB::raw($sql); 
         
        $row_count = $query->rowCount();
            
        $this->json([
            'code' => 0,
            'data' => $row_count
        ]);        
    }
}
