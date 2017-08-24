<?php

namespace YouDaoTranslateApi;

/**
 * Class Request
 * @package YouDaoTranslateApi
 * @author csun@hillinsight.com
 */
class Request
{
    const APP_NAME = 'my_api_dictionary';

    const API_URL_HTTP = 'http://openapi.youdao.com/api';
    const API_URL_HTTPS = 'https://openapi.youdao.com/api';
    const APP_KEY = '38c4b28e0f99fe23';
    const APP_SECRET = 'QAypRfPnRxslAHEt3RIqT21peasgC8vN';

    private $query = '你好';
    private $from = 'EN';
    private $to = 'zh-CHS';
    private $salt = 0;
    private $sign = '';

    private $url = '';

    const CHINESE = 'zh-CHS';
    const ENGLISH = 'EN';
    const AUTO = 'auto';


    public function translate($query = 'hello', $from = 'EN', $to = 'zh-CHS')
    {
        $this->salt = time();
        $this->query = $query;
        $this->from = $from;
        $this->to = $to;

        $this->genSign();
        $this->genUrl();
        $result = $this->send();
        return $result;
    }

    public function genSign()
    {
        $str = self::APP_KEY . $this->query . $this->salt . self::APP_SECRET;
        $this->sign = strtolower(md5($str));
    }

    public function genUrl()
    {
        $param = [
            'q'      => $this->query,
            'from'   => $this->from,
            'to'     => $this->to,
            'appKey' => self::APP_KEY,
            'salt'   => $this->salt,
            'sign'   => $this->sign,
        ];
        foreach ($param as $key => $value) {
            if ($key == 'q') {
                continue;
            }
            $param[$key] = urlencode($value);
        }
        $query = http_build_query($param);
        $this->url = self::API_URL_HTTPS . '?' . $query;
    }

    private function send()
    {
        $cs = curl_init();
        curl_setopt($cs, CURLOPT_URL, $this->url);
        curl_setopt($cs, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cs, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($cs, CURLOPT_TIMEOUT, 60);
        curl_setopt($cs, CURLOPT_SSL_VERIFYPEER, false); //这个是重点,规避ssl的证书检查。
        curl_setopt($cs, CURLOPT_SSL_VERIFYHOST, false); // 跳过host验证
        $result = curl_exec($cs);
        curl_close($cs);
        return $result;
    }
}

