<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:40 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

class MMPMessage extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["2"] = Transparent::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBInt::class;
        $this->values["4"] = "";
        $this->fields["5"] = PBInt::class;
        $this->values["5"] = "";
        $this->fields["6"] = PBInt::class;
        $this->values["6"] = "";
        $this->fields["7"] = PBBool::class;
        $this->values["7"] = "";
        $this->values["7"] = new PBBool();
        $this->values["7"]->value = true;
        $this->fields["8"] = PBInt::class;
        $this->values["8"] = "";
        $this->fields["9"] = PBString::class;
        $this->values["9"] = "";
        $this->fields["10"] = PBBool::class;
        $this->values["10"] = "";
        $this->values["10"] = new PBBool();
        $this->values["10"]->value = true;
    }

    function getTransparent()
    {
        return $this->_getValue("2");
    }
    function setTransparent($value)
    {
        return $this->_setValue("2", $value);
    }
    function getExtraData()
    {
        return $this->_getValue("3");
    }
    function setExtraData($value)
    {
        return $this->_setValue("3", $value);
    }
    function getMsgType()
    {
        return $this->_getValue("4");
    }
    function setMsgType($value)
    {
        return $this->_setValue("4", $value);
    }
    function getMsgTraceFlag()
    {
        return $this->_getValue("5");
    }
    function setMsgTraceFlag($value)
    {
        return $this->_setValue("5", $value);
    }
    function getMsgOfflineExpire()
    {
        return $this->_getValue("6");
    }
    function setMsgOfflineExpire($value)
    {
        return $this->_setValue("6", $value);
    }
    function getIsOffline()
    {
        return $this->_getValue("7");
    }
    function setIsOffline($value)
    {
        return $this->_setValue("7", $value);
    }
    function getPriority()
    {
        return $this->_getValue("8");
    }
    function setPriority($value)
    {
        return $this->_setValue("8", $value);
    }
    function getCdnUrl()
    {
        return $this->_getValue("9");
    }
    function setCdnUrl($value)
    {
        return $this->_setValue("9", $value);
    }
    function getIsSync()
    {
        return $this->_getValue("10");
    }
    function setIsSync($value)
    {
        return $this->_setValue("10", $value);
    }
}
