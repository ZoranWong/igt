<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:16 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBString;

class PushOSSingleMessage extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = OSMessage::class;
        $this->values["2"] = "";
        $this->fields["3"] = Target::class;
        $this->values["3"] = "";
    }
    function seqId()
    {
        return $this->_getValue("1");
    }
    function set_seqId($value)
    {
        return $this->_setValue("1", $value);
    }
    function message()
    {
        return $this->_getValue("2");
    }
    function set_message($value)
    {
        return $this->_setValue("2", $value);
    }
    function target()
    {
        return $this->_getValue("3");
    }
    function set_target($value)
    {
        return $this->_setValue("3", $value);
    }
}
