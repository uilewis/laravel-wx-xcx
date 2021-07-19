<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 2017/8/10
 */

return [
    /**
     * 小程序APP ID
     */
    'app_id' => '',
    /**
     * 小程序Secret
     */
    'secret' => '',
    /**
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",

    /**
     * 小程序access_token获取地址 ，不需要改动
     */
    'access_token_url' => "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",

];