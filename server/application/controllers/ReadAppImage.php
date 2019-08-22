<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \QCloud_WeApp_SDK\Auth\LoginService as LoginService;
use QCloud_WeApp_SDK\Constants as Constants;
use QCloud_WeApp_SDK\Mysql\Mysql as DB;

require_once '../../config.php';

class ReadAppImage extends CI_Controller {
    public function index() {
        $result = LoginService::check(); 

        if ($result['loginState'] === Constants::S_AUTH) {
          //token存在缓存中  
          //$access_token=M::Get('q*******en_'.$appid);  
          //if(!$access_token){  
          $url_access_token = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$config['appId']."&secret=".$config['appSecret'];   
          $json_access_token = send_post($url_access_token,array());  
          //access_token加缓存  
          $arr_access_token = json_decode($json_access_token,true);  
          $access_token = $arr_access_token['access_token'];  
          //M::Set('q******ken_'.$appid,$access_token,3600);  
          //}  
         if(!empty($access_token)) {  
           $url = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$access_token;      
           $data = '{"path": "/pages/a*****/index?id='.$sid.'", "width":430}';  
           $result = send_post($url,$data);  
           header('content-type:image/gif'); 
           echo $result;
  
            /*$dir = "/opt/c******wxaapp/";  
            $path = $dir.date("Y/m/d/")."/".rand(1,50)."/";  
            create_dirs($path,0777);  
            $file_name = time().".png";  
            
            file_put_contents($path.$file_name,$result);  
            $url = 'https://www.q****om/'.str_replace('/op*****baby/','',$path.$file_name);  
    
            $arr = array('ret'=>1,  
              'msg'=>'success',  
              'data'=>array('url'=>$url),   //返回保存在服务器中小程序码的地址  
            );*/
          } else {  
            $arr = array('ret'=>0,'msg'=>'ACCESS TOKEN为空！');  
          }  
          //echo json_encode($arr);

          

        } else {
            $this->json([
                'code' => -1,
                'data' => -1
            ]);
        }
    }

    private function send_post($url, $post_data) {
    $curl = curl_init(); // 启动一个CURL会话        
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址                    
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测      
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在        
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交       
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转        
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer        
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求        
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包        
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循       
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容        
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回   
             
    $tmpInfo = curl_exec($curl); // 执行操作        
    if (curl_errno($curl)) {        
       echo 'Errno'.curl_error($curl);        
    }        
    curl_close($curl); // 关键CURL会话        
    return $tmpInfo; // 返回数据
  }

}

/*
        array(9) {
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
  array(2) {
    ["timestamp"]=>
    int(1520356124)
    ["appid"]=>
    string(18) "wx6ac26d5de9227351"
  }
}
*/
