<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:27 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

class ReqServListResult extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBInt::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = [];
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
    }

    public function getCode()
    {
        return $this->_getValue("1");
    }

    public function setCode($value)
    {
        return $this->_setValue("1", $value);
    }

    public function getHost($offset)
    {
        $v = $this->_getArrValue("2", $offset);
        return $v->getValue();
    }

    public function appendHost($value)
    {
        $v = $this->_addArrValue("2");
        $v->setValue($value);
    }

    public function setHost($index, $value)
    {
        $v = new $this->fields["2"]();
        $v->setValue($value);
        $this->_setArrValue("2", $index, $v);
    }

    public function removeLastHost()
    {
        $this->_removeLastArrValue("2");
    }

    public function hostSize()
    {
        return $this->_getArrSize("2");
    }

    public function getSeqId()
    {
        return $this->_getValue("3");
    }

    public function setSeqId($value)
    {
        return $this->_setValue("3", $value);
    }
}
