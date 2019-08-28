
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OpenId extends CI_Controller {
  public function index()
  {
      $code = $_GET['code'];//小程序传来的code值
      $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx76aec7d8d5f5083f&secret=de369b1d7fcb9d07cecb30a7ea30fbf1&js_code=' . $code . '&grant_type=authorization_code';
      //yourAppid为开发者appid.appSecret为开发者的appsecret,都可以从微信公众平台获取；
      $info = file_get_contents($url);//发送HTTPs请求并获取返回的数据，推荐使用curl
      $json = json_decode($info);//对json数据解码
      $arr = get_object_vars($json);
      $openid = $arr['openid'];
      //$session_key = $arr['session_key'];
      
      // $con = mysqli_connect('localhost', 'root', '123');//连接数据库
      // if ($con) {
      //     if (mysqli_select_db($con, 'students')) {
      //         $sql1 = "select * from weixin where openid = '$openid'";
      //         $result = mysqli_query($con, $sql1);
      //         $result = mysqli_fetch_assoc($result);
      //         if ($result!=null) {//如果数据库中存在此用户的信息，则不需要重新获取
      //             $result = json_encode($result);
      //             echo $result;
      //         }
      //         else {//没有则将数据存入数据库
      //             if ($sex == '0') {
      //                 $sex = 'none';
      //             } else {
      //                 $sex = '1' ? 'man' : 'women';
      //             }
      //             $sql = "insert into weixin values ('$nick','$openid','$session_key','$imgUrl','$sex')";
      //             if (mysqli_query($con, $sql)) {
      //                 $arr['nick'] = $nick;
      //                 $arr['imgUrl'] = $imgUrl;
      //                 $arr['sex'] = $sex;
      //                 $arr = json_encode($arr);
      //                 echo $arr;
      //             } else {
      //                 die('failed' . mysqli_error($con));
      //             }
      //         }
      //     }
      // } else {
      //     die(mysqli_error());
      // }
   
      echo $openid;
      //return ($openid); 
  }
}
 
?>
