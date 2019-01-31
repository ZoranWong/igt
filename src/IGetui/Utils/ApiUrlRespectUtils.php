<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 8:04 PM
 */

namespace Zoran\IGt\IGetui\Utils;
use Zoran\IGt\IGetui\Utils\HttpManager;

class ApiUrlRespectUtils
{
    static $appKeyAndFasterHost = array();
    static $appKeyAndHost = array();
    static $appKeyAndLastExecuteTime = array();
    public static function getFastest($appKey,$hosts)
    {
        if ($hosts == null || count($hosts)==0) {
            throw new \Exception("Hosts cann't be null or size must greater than 0");
        }

        if(isset(self::$appKeyAndFasterHost[$appKey]) && count(array_diff($hosts,isset(self::$appKeyAndHost[$appKey])?self::$appKeyAndHost[$appKey]:null)) == 0) {
            return self::$appKeyAndFasterHost[$appKey];
        } else {
            $fastest = self::getFastestRealTime($hosts);
            self::$appKeyAndHost[$appKey] = $hosts;
            self::$appKeyAndFasterHost[$appKey] = $fastest;
            return $fastest;
        }
    }

    public static function getFastestRealTime($hosts)
    {
        $mint=60.0;
        $s_url="";
        for ($i=0;$i<count($hosts);$i++) {
            $start = array_sum(explode(" ",microtime()));
            try {
                $homepage = HttpManager::httpHead($hosts[$i]);
            } catch (Exception $e) {
                echo($e);
            }
            $ends = array_sum(explode(" ",microtime()));
            $diff=$ends-$start;
            if ($mint > $diff)
            {
                $mint=$diff;
                $s_url=$hosts[$i];
            }
        }
        return $s_url;
    }
}
