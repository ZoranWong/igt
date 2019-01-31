<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:03 PM
 */

namespace Zoran\IGt\IGetui\APN;

/**
 * @property string $alertMsg
 * */
class SimpleAlertMsg implements ApnMsg
{
    protected $alertMsg;

    public function getAlertMsg()
    {
        // TODO: Implement getAlertMsg() method.
        return $this->alertMsg;
    }

    public function setAlertMsg($value)
    {
        // TODO: Implement getAlertMsg() method.
        return $this->alertMsg = $value;
    }
}
