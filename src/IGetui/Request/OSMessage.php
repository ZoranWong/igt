<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:09 PM
 */

namespace Zoran\IGt\IGetui\Request;

use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

class OSMessage extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["2"] = PBBool::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBInt::class;
        $this->values["3"] = "";
        $this->fields["4"] = Transparent::class;
        $this->values["4"] = "";
        $this->fields["5"] = PBString::class;
        $this->values["5"] = "";
        $this->fields["6"] = PBInt::class;
        $this->values["6"] = "";
        $this->fields["7"] = PBInt::class;
        $this->values["7"] = "";
        $this->fields["8"] = PBInt::class;
        $this->values["8"] = "";
    }
    public function getIsOffline()
    {
        return $this->_getValue("2");
    }
    public function setIsOffline($value)
    {
        return $this->_setValue("2", $value);
    }
    public function getOfflineExpireTime()
    {
        return $this->_getValue("3");
    }
    public function setOfflineExpireTime($value)
    {
        return $this->_setValue("3", $value);
    }
    public function getTransparent()
    {
        return $this->_getValue("4");
    }
    public function setTransparent($value)
    {
        return $this->_setValue("4", $value);
    }
    public function getExtraData()
    {
        return $this->_getValue("5");
    }
    public function setExtraData($value)
    {
        return $this->_setValue("5", $value);
    }
    public function getMsgType()
    {
        return $this->_getValue("6");
    }
    public function setMsgType($value)
    {
        return $this->_setValue("6", $value);
    }
    public function getMsgTraceFlag()
    {
        return $this->_getValue("7");
    }
    public function setMsgTraceFlag($value)
    {
        return $this->_setValue("7", $value);
    }
    public function getPriority()
    {
        return $this->_getValue("8");
    }

    public function setPriority($value)
    {
        return $this->_setValue("8", $value);
    }
}

