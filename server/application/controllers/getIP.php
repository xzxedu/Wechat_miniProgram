<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getIP extends CI_Controller {
    public function index() {
        echo $this -> input -> server('REMOTE_ADDR')
        //对应的路径
        $this -> load -> view('weapp/index')
    }
}