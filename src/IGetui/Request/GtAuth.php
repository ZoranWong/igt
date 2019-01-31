<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 2:24 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

/**
 * @property string $sign
 * @property string $appKey
 * @property string $timestamp
 * @property string $seqId
 * */
class GtAuth extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBInt::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
    }
    public function getSign()
    {
        return $this->_getValue("1");
    }

    public function setSign($value)
    {
        $this->_setValue("1", $value);
    }

    public function getAppKey()
    {
        return $this->_getValue("2");
    }

    public function setAppKey($value)
    {
        $this->_setValue("2", $value);
    }

    public  function getTimestamp()
    {
        return $this->_getValue("3");
    }

    public  function setTimestamp($value)
    {
        $this->_setValue("3", $value);
    }

    public function getSeqId()
    {
        return $this->_getValue("4");
    }

    public function setSeqId($value)
    {
        $this->_setValue("4", $value);
    }
}
