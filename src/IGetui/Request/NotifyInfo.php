<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:34 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBString;

class NotifyInfo extends PBMessage
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
        $this->fields["6"] = NotifyInfoType::class;
        $this->values["6"] = "";
        $this->values["6"] = new NotifyInfoType();
        $this->values["6"]->value = NotifyInfoType::_payload;
        $this->fields["7"] =  PBString::class;
        $this->values["7"] = "";
    }
    public function getTitle()
    {
        return $this->_getValue("1");
    }

    public function setTitle($value)
    {
        return $this->_setValue("1", $value);
    }


    public function getContent()
    {
        return $this->_getValue("2");
    }


    public function setContent($value)
    {
        return $this->_setValue("2", $value);
    }

    public function getPayload()
    {
        return $this->_getValue("3");
    }

    public function setPayload($value)
    {
        return $this->_setValue("3", $value);
    }

    public function getIntent()
    {
        return $this->_getValue("4");
    }

    public function setIntent($value)
    {
        return $this->_setValue("4", $value);
    }

    public function getUrl()
    {
        return $this->_getValue("5");
    }

    public function setUrl($value)
    {
        return $this->_setValue("5", $value);
    }

    public function getType()
    {
        return $this->_getValue("6");
    }

    public function setType($value)
    {
        return $this->_setValue("6", $value);
    }

    public function getNotifyId()
    {
        return $this->_getValue("7");
    }

    public function setNotifyId($value)
    {
        return $this->_setValue("7", $value);
    }
}
