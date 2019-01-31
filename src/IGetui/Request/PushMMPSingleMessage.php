<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:31 PM
 */

namespace Zoran\IGt\IGetui\Request;

use Zoran\IGt\ProtoBuf\Type\PBString;

class PushMMPSingleMessage extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = MMPMessage::class;
        $this->values["2"] = "";
        $this->fields["3"] = Target::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
    }
    function getSeqId()
    {
        return $this->_getValue("1");
    }
    function setSeqId($value)
    {
        return $this->_setValue("1", $value);
    }
    function getMessage()
    {
        return $this->_getValue("2");
    }
    function setMessage($value)
    {
        return $this->_setValue("2", $value);
    }
    function getTarget()
    {
        return $this->_getValue("3");
    }
    function setTarget($value)
    {
        return $this->_setValue("3", $value);
    }
    function getRequestId()
    {
        return $this->_getValue("4");
    }
    function setRequestId($value)
    {
        return $this->_setValue("4", $value);
    }
}

