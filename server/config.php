<?php
/**
 * Wafer php demo 配置文件
 */

$config = [
    'rootPath' => '',

    // 微信小程序 AppID
    'appId' => 'wx76aec7d8d5f5083f',

    // 微信小程序 AppSecret
    'appSecret' => 'de369b1d7fcb9d07cecb30a7ea30fbf1',

    // 使用腾讯云代理登录
    'useQcloudLogin' => false,

    /**
     * MySQL 配置，用来存储 session 和用户信息
     * 若使用了腾讯云微信小程序解决方案
     * 开发环境下，MySQL 的初始密码为您的微信小程序 AppID
     */
    'mysql' => [
        'host' => '172.27.0.9',
        'port' => 3306,
        'user' => 'root',
        'db'   => 'quant',
        'pass' => 'wechatdemo123',
        'char' => 'utf8mb4'
    ],

    'cos' => [
        /**
         * 区域
         * 上海：cn-east
         * 广州：cn-sorth
         * 北京：cn-north
         * 广州二区：cn-south-2
         * 成都：cn-southwest
         * 新加坡：sg
         * @see https://www.qcloud.com/document/product/436/6224
         */
        'region' => 'ap-beijing',
        // Bucket 名称
        'fileBucket' => 'fe-1255989678',
        // 文件夹
        'uploadFolder' => ''
    ],

    'serverHost' => 'https://xzx.faithforfuture.com',
    'tunnelServerUrl' => 'http://tunnel.ws.qcloud.la',
    'tunnelSignatureKey' => '27fb7d1c161b7ca52d73cce0f1d833f9f5b5ec89', //tunnelSignatureKey 修改成自己的签名秘钥，随便自己定义一个就行
      // 腾讯云相关配置可以查看云 API 秘钥控制台：https://console.cloud.tencent.com/capi
    'qcloudAppId' => 1255989678,// 必须是数字
    'qcloudSecretId' => 'AKIDGNJ3ZtJw65rRpzkgIjvvkLhqlW2KkGtI',
    'qcloudSecretKey' => 'KQL2UjmcDaidJk285pLejaCZjfNq57xY',


    



    // 微信登录态有效期
    'wxLoginExpires' => 7200,
    'wxMessageToken' => 'abcdefgh'
];
