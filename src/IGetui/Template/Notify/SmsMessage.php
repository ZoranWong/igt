<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:33 AM
 */

namespace Zoran\IGt\IGetui\Template\Notify;

/**
 * @property string $smsTemplateId
 * @property string|array $smsContent
 * @property int $offlineSendTime
 * @property string $url
 * @property boolean $isAppLink
 * @property array|string $payload
 * */
class SmsMessage
{
    protected $smsTemplateId;
    /**
     * 短信填充
     */
    protected $smsContent;
    /**
     * 离线多久后进行消息补发
     */
    protected $offlineSendTime;

    protected $url;//Applink路径
    protected $isAppLink;
    protected $payload;

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name = $value;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->$name;
    }
}
