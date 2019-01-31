<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:34 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBString;

class ServerNotifyResult extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
    }
    function getSeqId()
    {
        return $this->_getValue("1");
    }
    function setSeqId($value)
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
}
