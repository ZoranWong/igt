<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:56 PM
 */

namespace Zoran\IGt\IGetui\Request;

use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBString;

/**
 * @property string $key
 * @property string $value
 */
class SmsContentEntry extends PBMessage
{
    var $wired_type = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
    }
    function getKey()
    {
        return $this->_getValue("1");
    }
    function setKey($value)
    {
        return $this->_setValue("1", $value);
    }
    function getValue()
    {
        return $this->_getValue("2");
    }
    function setValue($value)
    {
        return $this->_setValue("2", $value);
    }
}

