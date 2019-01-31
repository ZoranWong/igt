<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:48 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

/**
 * @property bool $smsChecked
 * @property string $smsTemplateId
 * @property int $offlineSendTime
 * @property int $smsSendDuration
 */
class SmsInfo extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = SmsContentEntry::class;
        $this->values["2"] = array();
        $this->fields["3"] = PBInt::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBInt::class;
        $this->values["4"] = "";
        $this->fields["5"] = PBBool::class;
        $this->values["5"] = "";
        $this->values["5"] = new PBBool();
        $this->values["5"]->value = false;
        $this->fields["6"] = PBString::class;
        $this->values["6"] = "";
    }
    function getSmsTemplateId()
    {
        return $this->_getValue("1");
    }
    function setSmsTemplateId($value)
    {
        return $this->_setValue("1", $value);
    }
    function smsContent($offset)
    {
        return $this->_getArrValue("2", $offset);
    }
    function addSmsContent()
    {
        return $this->_addArrValue("2");
    }
    function setSmsContent($index, $value)
    {
        $this->_setArrValue("2", $index, $value);
    }
    function removeLastSmsContent()
    {
        $this->_removeLastArrValue("2");
    }
    function getSmsContentSize()
    {
        return $this->_getArrSize("2");
    }
    function getOfflineSendTime()
    {
        return $this->_getValue("3");
    }
    function setOfflineSendTime($value)
    {
        return $this->_setValue("3", $value);
    }
    function getSmsSendDuration()
    {
        return $this->_getValue("4");
    }
    function setSmsSendDuration($value)
    {
        return $this->_setValue("4", $value);
    }
    function getSmsChecked()
    {
        return $this->_getValue("5");
    }
    function setSmsChecked($value)
    {
        return $this->_setValue("5", $value);
    }
    function getSmsCheckedErrorMsg()
    {
        return $this->_getValue("6");
    }
    function setSmsCheckedErrorMsg($value)
    {
        return $this->_setValue("6", $value);
    }
}
