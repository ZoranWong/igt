<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:59 AM
 */

namespace Zoran\IGt\IGetui\Utils;


class LogUtils
{
    static $debug = true;
    public static function debug($log)
    {
        if (LogUtils::$debug)
            echo date('y-m-d h:i:s',time()).($log) . "\r\n";
    }
}
