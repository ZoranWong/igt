<?php
namespace Zoran\IGt\IGetui\Message;
use Zoran\IGt\IGetui\Template\BaseTemplate;

/**
 * @property boolean $isOffline
 * @property int $offlineExpireTime
 * @property int $pushNetWorkType
 * @property BaseTemplate $data
 * */
class BaseMessage
{
    protected  $isOffline;
    /*
     * 过多久该消息离线失效（单位毫秒） 支持1-72小时*3600000秒，默认1小时
     */
    protected $offlineExpireTime;

    /**
     * 0:联网方式不限;1:仅wifi;2:仅4G/3G/2G
     */
    protected $pushNetWorkType = 0;

    protected $data;

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->$name;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name  = $value;
    }

}
