<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:04 AM
 */

namespace Zoran\IGt\IGetui\Utils;

class GTConfig
{

    public static function isPushSingleBatchAsync()
    {
        return "true" == GTConfig::getProperty("gexin_push_single_batch_need_async", null, "false");
    }

    public static function isPushListAsync()
    {
        return "true" == GTConfig::getProperty("gexin_pushList_need_async", null, "false");
    }

    public static function isPushListNeedDetails()
    {
        return "true" == GTConfig::getProperty("gexin_push_list_need_details", "needDetails", "false");
    }

    public static function getHttpProxyIp()
    {
        return GTConfig::getProperty("gexin_http_proxy_ip", "gexin.rp.sdk.http.proxyHost");
    }

    public static function getHttpProxyPort()
    {
        return (int)GTConfig::getProperty("gexin_http_proxy_port", "gexin.rp.sdk.http.proxyPort", 80);
    }
    public static function getHttpProxyUserName()
    {
        return GTConfig::getProperty("gexin_http_proxy_username", "gexin.rp.sdk.http.proxyUserName");
    }

    public static function getHttpProxyPasswd()
    {
        return GTConfig::getProperty("gexin_http_proxy_passwd", "gexin.rp.sdk.http.proxyPasswd");
    }

    public static function getSyncListLimit()
    {
        return (int)GTConfig::getProperty("gexin_push_list_sync_limit", null, 1000);
    }

    public static function getAsyncListLimit()
    {
        return (int)GTConfig::getProperty("gexin_push_list_async_limit", null, 10000);
    }

    public static function getTagListLimit()
    {
        return (int)GTConfig::getProperty("gexin_tag_list_limit", null, 10);
    }

    public static function getHttpConnectionTimeOut()
    {
        return (int)GTConfig::getProperty("gexin_http_connection_timeout", "gexin.rp.sdk.http.connection.timeout", 60000);
    }

    public static function getHttpInspectInterval()
    {
        return (int)GTConfig::getProperty("gexin_inspect_interval", "gexin.rp.sdk.http.inspect.timeout", 300000);
    }


    public static function getHttpSoTimeOut()
    {
        return (int)GTConfig::getProperty("gexin_http_so_timeout", "gexin.rp.sdk.http.so.timeout", 30000);
    }

    public static function getHttpTryCount()
    {
        return (int)GTConfig::getProperty("gexin_http_try_count", "gexin.rp.sdk.http.gexinTryCount", 3);
    }

    public static function getMaxLenOfBlackCidList(){
        return (int)GTConfig::getProperty("gexin_max_blk_cid_length", null, 1000);
    }

    public static function getDefaultDomainUrl($useSSL)
    {
        $urlStr = GTConfig::getProperty("gexin_default_domain_url", null);
        if ($urlStr == null || "" === trim($urlStr)) {
            if ($useSSL) {
                $hosts = [
                    "https://cncapi.getui.com/serviceex","https://telapi.getui.com/serviceex",
                    "https://api.getui.com/serviceex","https://sdk1api.getui.com/serviceex",
                    "https://sdk2api.getui.com/serviceex","https://sdk3api.getui.com/serviceex"];
            } else {
                $hosts = [
                    "http://sdk.open.api.igexin.com/serviceex","http://sdk.open.api.gepush.com/serviceex",
                    "http://sdk.open.api.getui.net/serviceex","http://sdk1.open.api.igexin.com/serviceex",
                    "http://sdk2.open.api.igexin.com/serviceex","http://sdk3.open.api.igexin.com/serviceex"];
            }
        } else {
            $list = explode(",",$urlStr);
            $hosts = [];
            foreach ($list as $value) {
                if (strpos($value, "https://") === 0 && !$useSSL) {
                    continue;
                }

                if (strpos($value, "http://") === 0 && $useSSL) {
                    continue;
                }

                if ($useSSL && strpos($value, "http") != 0) {
                    $value = "https://".$value;
                }
                array_push($hosts, $value);
            }
        }
        return $hosts;
    }

    private static function getProperty($key, $oldKey, $defaultValue = null)
    {
        $value = getenv(strtoupper($key));
        if($value != null) {
            return $value;
        } else if($oldKey != null) {
                $value = getenv(strtoupper($oldKey));
        }

        if($value == null) {
            return $defaultValue;
        } else {
            return $value;
        }
    }

    public static function getNotifyIntentLimit()
    {
        return (int)GTConfig::getProperty("notify_intent_limit", null, 1000);
    }

    public static function getStartActivityIntentLimit()
    {
        return (int)GTConfig::getProperty("start_activity_intent_limit", null, 1000);
    }

    public static function getSDKVersion()
    {
        return "4.1.0.0";
    }
}

