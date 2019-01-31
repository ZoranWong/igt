<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:18 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;

class AppStartUp extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBString";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
        $this->fields["3"] = "PBString";
        $this->values["3"] = "";
    }

    public function getAndroid()
    {
        return $this->_getValue("1");
    }

    public function setAndroid($value)
    {
        return $this->_setValue("1", $value);
    }

    public function getSymbia()
    {
        return $this->_getValue("2");
    }

    public function setSymbia($value)
    {
        return $this->_setValue("2", $value);
    }

    public function getIos()
    {
        return $this->_getValue("3");
    }

    public function setIos($value)
    {
        return $this->_setValue("3", $value);
    }
}
