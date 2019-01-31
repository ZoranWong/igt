<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:32 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

/**
 * @property bool $invalidMPN
 * @property bool $invalidAPN
 * @property string $apnJson
 */
class PushInfo extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] =  PBString::class;
        $this->values["2"] = "";
        $this->fields["3"] =  PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] =  PBString::class;
        $this->values["4"] = "";
        $this->fields["5"] =  PBString::class;
        $this->values["5"] = "";
        $this->fields["6"] =  PBString::class;
        $this->values["6"] = "";
        $this->fields["7"] =  PBString::class;
        $this->values["7"] = "";
        $this->fields["8"] =  PBString::class;
        $this->values["8"] = "";
        $this->fields["9"] =  PBString::class;
        $this->values["9"] = "";
        $this->fields["10"] = PBInt::class;
        $this->values["10"] = "";
        $this->fields["11"] = PBBool::class;
        $this->values["11"] = "";
        $this->fields["12"] =  PBString::class;
        $this->values["12"] = "";
        $this->fields["13"] = PBBool::class;
        $this->values["13"] = "";
        $this->fields["14"] =  PBString::class;
        $this->values["14"] = "";
        $this->fields["15"] = PBBool::class;
        $this->values["15"] = "";
        $this->fields["16"] = NotifyInfo::class;
        $this->values["16"] = "";
    }
    function getMessage()
    {
        return $this->_getValue("1");
    }
    function setMessage($value)
    {
        return $this->_setValue("1", $value);
    }
    function getActionKey()
    {
        return $this->_getValue("2");
    }
    function setActionKey($value)
    {
        return $this->_setValue("2", $value);
    }
    function getSound()
    {
        return $this->_getValue("3");
    }
    function setSound($value)
    {
        return $this->_setValue("3", $value);
    }
    function getBadge()
    {
        return $this->_getValue("4");
    }
    function setBadge($value)
    {
        return $this->_setValue("4", $value);
    }
    function getPayload()
    {
        return $this->_getValue("5");
    }
    function setPayload($value)
    {
        return $this->_setValue("5", $value);
    }
    function getLocKey()
    {
        return $this->_getValue("6");
    }
    function setLocKey($value)
    {
        return $this->_setValue("6", $value);
    }
    function getLocArgs()
    {
        return $this->_getValue("7");
    }
    function setLocArgs($value)
    {
        return $this->_setValue("7", $value);
    }
    function getActionLocKey()
    {
        return $this->_getValue("8");
    }
    function setActionLocKey($value)
    {
        return $this->_setValue("8", $value);
    }
    function getLaunchImage()
    {
        return $this->_getValue("9");
    }
    function setLaunchImage($value)
    {
        return $this->_setValue("9", $value);
    }
    function getContentAvailable()
    {
        return $this->_getValue("10");
    }
    function setContentAvailable($value)
    {
        return $this->_setValue("10", $value);
    }
    function getInvalidAPN()
    {
        return $this->_getValue("11");
    }
    function setInvalidAPN($value)
    {
        return $this->_setValue("11", $value);
    }
    function getApnJson()
    {
        return $this->_getValue("12");
    }
    function setApnJson($value)
    {
        return $this->_setValue("12", $value);
    }
    function getInvalidMPN()
    {
        return $this->_getValue("13");
    }
    function setInvalidMPN($value)
    {
        return $this->_setValue("13", $value);
    }
    function getMpnXml()
    {
        return $this->_getValue("14");
    }
    function setMpnXml($value)
    {
        return $this->_setValue("14", $value);
    }
    function getValidNotify()
    {
        return $this->_getValue("15");
    }
    function setValidNotify($value)
    {
        return $this->_setValue("15", $value);
    }
    function getNotifyInfo()
    {
        return $this->_getValue("16");
    }
    function setNotifyInfo($value)
    {
        return $this->_setValue("16", $value);
    }
}
