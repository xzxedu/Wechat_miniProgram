<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class GetIP extends CI_Controller {

    public function index(){
        $open_id = $_POST['open_id'];

        $ip=false;

        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }

        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ips=explode (', ', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if($ip){ array_unshift($ips, $ip); $ip=FALSE; }
            for ($i=0; $i < count($ips); $i++){
                if(!eregi ('^(10│172.16│192.168).', $ips[$i])){
                    $ip=$ips[$i];
                    break;
                }
            }
        };
        
        $ip = $ip ? $ip : $_SERVER['REMOTE_ADDR'];

        $this->json([
            'ip address' => $ip
        ]);
        
        // $only_ip =  utf8_encode($ip);
        // // insert IP address into mysql cloud database
        // DB::insert('userInfo', [
        //     'ip_address' => $only_ip
        // ]);

        //连接数据库
        $this -> load -> database();
        $query = $this->db->query("SELECT * FROM userInfo WHERE open_id = 'open_id' ");
        $query = $query -> result();
        var_dump($query);

        if ($query != null) {
            $query = json_encode($query);
            echo 'aaaa';
            echo $query;
        }
        else {
          $open_id = trim($open_id);
          $data = array(
                       'open_id' => $open_id,
                       'ip_address' => $ip 
                       ); 
          $this->db->insert('userInfo', $data);
        }

        return ($ip);
    }

}