<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

class ReadAppCode extends CI_Controller {
    public function index() {
      $scene = isset($_GET['scene']) ? $_GET['scene'] : ' no post scene';
      log_message('error',"scene".$scene); 
        //$result = LoginService::check(); 

        //if ($result['loginState'] === Constants::S_AUTH) {
          // 微信小程序 AppID
          $appId = 'wx3a3bcb08df731cb5';

          // 微信小程序 AppSecret
          $appSecret = '6106ff44b7fd537f01ae21c703728292';

          //token存在缓存中  
          //$access_token=M::Get('q*******en_'.$appid);  
          //if(!$access_token){  
          $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;   
          //$json_access_token = $this->send_post($url_access_token,array()); 
          $json_access_token = $this->curl_get($url_access_token); 
          //access_token加缓存  
          $arr_access_token = json_decode($json_access_token,true);  
          $access_token = $arr_access_token['access_token'];  
          //M::Set('q******ken_'.$appid,$access_token,3600);  
          //}
          //echo $access_token;

          header('content-type:image/jpg'); 

         if(!empty($access_token)) {  
           $url = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token='.$access_token;    
           $data = array();
           $data['scene'] = $scene;
           $data['page'] = "pages/index/index";
           $data = json_encode($data);             
           $result = $this->send_post($url,$data);  
           
           echo $result;           
  
            /*$dir = "/data/release/fe/appcode/";  
            $path = $dir.date("Y/m/d/")."/".rand(1,50)."/";  
            create_dirs($path,0777);  
            $file_name = time().".png";  
            
            file_put_contents($path.$file_name,$result);  
            $url = 'https://www.faithforfuture.com/appcode/'.$file_name;  
    
            $arr = array('ret'=>1,  
              'msg'=>'success',  
              'data'=>array('url'=>$url),   //返回保存在服务器中小程序码的地址  
            );*/
          } else {  
            $arr = array('ret'=>0,'msg'=>'ACCESS TOKEN为空！');  
            echo json_encode($arr);
          }        
        /*} else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }*/
    }

    private function curl_get($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        return $data;
    }

    private function send_post($url, $data) {
      $curl = curl_init(); // 启动一个CURL会话
      //$headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache");             
      curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                    
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检测      
      //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在        
      //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交       
      //curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转        
      //curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer        
      curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求        
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包        
      curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循       
      //curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容        
      //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回   
      //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
              
      $tmpInfo = curl_exec($curl); // 执行操作        
      //if (curl_errno($curl)) {        
      //  echo 'Errno'.curl_error($curl);        
      //}        
      curl_close($curl); // 关键CURL会话        
      return $tmpInfo; // 返回数据
    }

}
