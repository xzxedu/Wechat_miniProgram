<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GetIP extends CI_Controller {

    public function index(){

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
        }

        $this->json([
            'code' => $ip ? $ip : $_SERVER['REMOTE_ADDR'],
            'data' => [
                'msg' => 'GET IP ADDRESS'
            ]
        ]);

        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }

}