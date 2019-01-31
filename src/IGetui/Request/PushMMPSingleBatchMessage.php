<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:37 PM
 */

namespace Zoran\IGt\IGetui\Request;

use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBString;

class PushMMPSingleBatchMessage extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PushMMPSingleMessage::class;
        $this->values["2"] = array();
        $this->fields["3"] = PBBool::class;
        $this->values["3"] = "";
        $this->values["3"] = new PBBool();
        $this->values["3"]->value = true;
    }
    function batchId()
    {
        return $this->_getValue("1");
    }
    function set_batchId($value)
    {
        return $this->_setValue("1", $value);
    }
    function batchItem($offset)
    {
        return $this->_get_arr_value("2", $offset);
    }
    function add_batchItem()
    {
        return $this->_add_arr_value("2");
    }
    function set_batchItem($index, $value)
    {
        $this->_set_arr_value("2", $index, $value);
    }
    function remove_last_batchItem()
    {
        $this->_remove_last_arr_value("2");
    }
    function batchItem_size()
    {
        return $this->_get_arr_size("2");
    }
    function isSync()
    {
        return $this->_getValue("3");
    }
    function set_isSync($value)
    {
        return $this->_setValue("3", $value);
    }
}

