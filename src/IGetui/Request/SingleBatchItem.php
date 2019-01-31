<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:42 PM
 */

namespace Zoran\IGt\IGetui\Request;

use Zoran\IGt\ProtoBuf\PBMessage;

class SingleBatchItem extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PBInt";
        $this->values["1"] = "";
        $this->fields["2"] = "PBString";
        $this->values["2"] = "";
    }
    function seqId()
    {
        return $this->_get_value("1");
    }
    function set_seqId($value)
    {
        return $this->_set_value("1", $value);
    }
    function data()
    {
        return $this->_get_value("2");
    }
    function set_data($value)
    {
        return $this->_set_value("2", $value);
    }
}

