<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 2017/3/3
 */

namespace UiLewis\WxXcx;


use Illuminate\Support\Facades\Log;
use UiLewis\WxXcx\Aes\WxBizDataCrypt;


class WxXcx
{
    private $appId;
    private $secret;
    private $code2session_url;
    private $access_token_url;

    public function __construct($config)
    {
        if(is_array($config)){
            $this->appId = $config['app_id'];
            $this->secret = $config['secret'];
            $this->code2session_url = $config['code2session_url'];
            $this->access_token_url = $config['access_token_url'];
        } else {
            Log::info(print_r($config, true));
        }



    }


    /**
     * @param $code
     * @return array
     */
    public function getLoginInfo($code)
    {
        return $this->authCodeAndCode2session($code);
    }


    /**
     * @param $encryptedData
     * @param $iv
     * @param $sessionKey
     * @return array|string
     */
    public function getDecryptData($encryptedData, $iv, $sessionKey)
    {
        $aes = new WxBizDataCrypt($this->appId, $sessionKey);
        $decode = '';
        $res = $aes->decryptData($encryptedData, $iv, $decode);
        if ($res != 0) {
            //return json_encode($res);
            return [
                'code' => 1001,
                'msg' => '解密失败'
            ];
        }
        if(json_decode($decode)){
            $decodeRs = json_decode($decode);
            $data = [
                'open_id' => $decodeRs->openId,
                'nick_name' => $decodeRs->nickName,
                'gender' => $decodeRs->gender,
                'language' => $decodeRs->language,
                'city' => $decodeRs->city,
                'province' => $decodeRs->province,
                'country' => $decodeRs->country,
                'avatar' => $decodeRs->avatarUrl,
            ];
            return $data;
        }

        return [
            'code' => 1001,
            'msg' => '解密失败'
        ];
    }


    /**
     * @param $code
     * @return array
     */
    private function authCodeAndCode2session($code)
    {
        $code2session_url = sprintf($this->code2session_url, $this->appId, $this->secret, $code);
        $userInfo = $this->httpRequest($code2session_url);

        if (!isset($userInfo['session_key'])) {
            return [
                'code' => 10000,
                'msg' => '获取 session_key 失败',
            ];
        }
        return $this->setSerSession($userInfo);
    }

    /**
     * @return bool|mixed
     */
    public function getAccessToken()
    {
        $url = sprintf($this->access_token_url, $this->appId, $this->secret);
        $tokenRs = $this->httpRequest($url);
        if (!isset($tokenRs['errcode'])) {
            if($tokenRs['errcode'] == 0){
                return $tokenRs;
            } else {
                return $tokenRs;
            }
        } else {
            return false;
        }
    }


    /**
     * @param $data
     * @param $key
     * @param $iv
     * @param string $method
     * @return string
     */
    public function myOpensslEncrypt($data, $key, $iv, $method = 'aes-256-cbc')
    {
        $encrypted = openssl_encrypt($data, $method, base64_decode($key), OPENSSL_RAW_DATA, base64_decode($iv));
        return base64_encode($encrypted);
    }

    /**
     * @param $data
     * @param $key
     * @param $iv
     * @param string $method
     * @return string
     */
    public function myOpensslDecrypt($data, $key, $iv, $method = 'aes-256-cbc')
    {
        $encrypted = base64_decode($data);
        $encrypted = openssl_encrypt($encrypted, $method, base64_decode($key), OPENSSL_RAW_DATA, base64_decode($iv));
        return base64_encode($encrypted);
    }


    /**
     * @param $url
     * @param array $data
     * @return mixed
     */
    public function httpRequest($url, $data = [])
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_PORT, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($curl);
        if (!$res) {
            die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
        }
        curl_close($curl);
        return json_decode($res, JSON_UNESCAPED_UNICODE);
    }


    /**
     * @param $userInfo
     * @return array
     */
    public function setSerSession($userInfo)
    {
        $data = [];
        if (isset($userInfo['openid']) && isset($userInfo['session_key'])) {
            //Log::info(print_r($userInfo, true));
            $data['open_id'] = $userInfo['openid'];
            $data['session_key'] = $userInfo['session_key'];
        }
        return $data;
    }



//    //发送模板消息 被弃用
//    public function sendXcxMsg($code)
//    {
//        $code2session_url = sprintf($this->code2session_url, $this->appId, $this->secret, $code);
//        //return $code2session_url;
//        $userInfo = $this->httpRequest($code2session_url);
//        if (!isset($userInfo['session_key'])) {
//            return [
//                'code' => 10000,
//                'msg' => '获取 session_key 失败',
//            ];
//        }
//        return $this->setSerSession($userInfo);
//    }
//


}