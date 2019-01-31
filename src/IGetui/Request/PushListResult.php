<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:59 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;

class PushListResult extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = "PushResult";
        $this->values["1"] = array();
    }
    function results($offset)
    {
        return $this->_get_arr_value("1", $offset);
    }
    function add_results()
    {
        return $this->_add_arr_value("1");
    }
    function set_results($index, $value)
    {
        $this->_set_arr_value("1", $index, $value);
    }
    function remove_last_results()
    {
        $this->_remove_last_arr_value("1");
    }
    function results_size()
    {
        return $this->_get_arr_size("1");
    }
}
