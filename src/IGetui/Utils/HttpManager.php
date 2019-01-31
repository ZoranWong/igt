<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:19 AM
 */

namespace Zoran\IGt\IGetui\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Zoran\IGt\IGetui\Utils\LogUtils;

class HttpManager
{
    const CURL_VERSION = 462850;

    public static function httpPost($url, $data, $gzip, $action = null)
    {
        list($headers, $options) = self::buildHttpHeadersAndOptions($gzip, $action);
        $httpClient = new Client();
        $body = json_encode($data);
        if($gzip) {
            $body = gzencode($body, 9);
        }
        $request = new Request('POST', $url, $headers, $body);
        return $httpClient->send($request, $options);
    }

    public static function httpHead($url)
    {
        list($headers, $options) = self::buildHttpHeadersAndOptions();
        $httpClient = new Client();
        $request = new Request('POST', $url, $headers);
        return $httpClient->send($request, $options);
    }


    protected static function buildHttpHeadersAndOptions($gzip = false, $action  = null)
    {
        $headers = [];
        $options = ['curl' => []];
        $options['curl'] = [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_BINARYTRANSFER => 1,
            CURLOPT_USERAGENT => 'GeTui php/1.0',
            CURLOPT_FORBID_REUSE => 0,
            CURLOPT_FRESH_CONNECT => 0,
            CURLOPT_CONNECTTIMEOUT_MS => GTConfig::getHttpConnectionTimeOut(),
            CURLOPT_TIMEOUT_MS => GTConfig::getHttpSoTimeOut(),
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0
        ];
        $headers['Content-Type'] = 'text/html;charset=UTF-8';
        $headers['Connection'] = 'Keep-Alive';

        if($gzip) {
            $headers['Accept-Encoding'] = 'gzip';
            $headers['Content-Encoding'] = 'gzip';
            $options['curl'][CURLOPT_ENCODING] = 'gzip';
        }

        $curlVersion = curl_version();
        if ($curlVersion['version_number'] >= self::CURL_VERSION) {
            $options['curl'][CURLOPT_CONNECTTIMEOUT_MS] = 30000;
            $options['curl'][CURLOPT_NOSIGNAL] = 1;
        }

        // 通过代理访问接口需要在此处配置代理
        $options['curl'][CURLOPT_PROXY] = GTConfig::getHttpProxyIp();
        $options['curl'][CURLOPT_PROXYPORT] = GTConfig::getHttpProxyPort();
        $options['curl'][CURLOPT_PROXYUSERNAME] = GTConfig::getHttpProxyUserName();
        $options['curl'][CURLOPT_PROXYPASSWORD] = GTConfig::getHttpProxyPasswd();
        $options['curl'][CURLOPT_RETURNTRANSFER] = 1; // return don't print
        $options['curl'][CURLOPT_TIMEOUT] = 30; //设置超时时间
        $options['curl'][CURLOPT_USERAGENT] = 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)';
        $options['curl'][CURLOPT_FOLLOWLOCATION] = 1; // 302 redirect
        $options['curl'][CURLOPT_MAXREDIRS] = 7; //HTTp定向级别

        if(!is_null($action)) {
            $headers['Gt-Action'] = $action;
        }
        return [$headers, $options];
    }
}
