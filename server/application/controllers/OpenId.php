
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OpenId extends CI_Controller {
  public function index()
  {
      $code = $_GET['code'];//小程序传来的code值
      $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx76aec7d8d5f5083f&secret=de369b1d7fcb9d07cecb30a7ea30fbf1&js_code=' . $code . '&grant_type=authorization_code';
      
      //发送HTTPs请求并获取返回的数据，推荐使用curl
      $info = file_get_contents($url);
      $json = json_decode($info);
      $arr = get_object_vars($json);
      $openid = $arr['openid'];
      //$session_key = $arr['session_key'];
      
      echo $openid;
      //return ($openid); 
  }
}
 
?>
