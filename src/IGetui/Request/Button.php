<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:18 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;

class Button extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBInt";
        $this->values["2"] = "";
    }

    public function getText()
    {
        return $this->_getValue("1");
    }

    public function setText($value)
    {
        return $this->_setValue("1", $value);
    }

    public function getNext()
    {
        return $this->_getValue("2");
    }

    public function setNext($value)
    {
        return $this->_setValue("2", $value);
    }
}

