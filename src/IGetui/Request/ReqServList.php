<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:24 PM
 */

namespace Zoran\IGt\IGetui\Request;



use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

class ReqServList extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBInt::class;
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
    function getTimestamp()
    {
        return $this->_getValue("2");
    }
    function setTimestamp($value)
    {
        return $this->_setValue("2", $value);
    }
}
