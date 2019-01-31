<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:37 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBString;

class ServerNotify extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = ServerNotifyType::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
    }
    function getType()
    {
        return $this->_getValue("1");
    }
    function setType($value)
    {
        return $this->_setValue("1", $value);
    }
    function getInfo()
    {
        return $this->_getValue("2");
    }
    function setInfo($value)
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
    function getSeqId()
    {
        return $this->_getValue("4");
    }
    function setSeqId($value)
    {
        return $this->_setValue("4", $value);
    }
}
