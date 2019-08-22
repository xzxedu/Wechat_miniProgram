<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class ReadMultipleActivityOfUser extends CI_Controller {
    public function index() {        
        $userId = isset($_POST['userId']) ? $_POST['userId'] : '0';      

        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
            //$res = DB::row('gActivity', ['*'], compact('id')); 
            $sql = "SELECT * FROM gActivity WHERE  id IN (SELECT  activity_id FROM gActivityUser WHERE user_id=".$userId." and state=1) and state=1";
            
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
}
