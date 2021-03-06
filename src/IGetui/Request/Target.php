<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:53 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBString;

class Target extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
    }
    function getAppId()
    {
        return $this->_getValue("1");
    }
    function setAppId($value)
    {
        return $this->_setValue("1", $value);
    }
    function getClientId()
    {
        return $this->_getValue("2");
    }
    function setClientId($value)
    {
        return $this->_setValue("2", $value);
    }
    function getAlias()
    {
        return $this->_getValue("3");
    }
    function setAlias($value)
    {
        return $this->_setValue("3", $value);
    }
}

