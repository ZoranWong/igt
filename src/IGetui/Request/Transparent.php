<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:28 PM
 */

namespace Zoran\IGt\IGetui\Request;

use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

/**
 * @property string $templateId
 * @property string $id
 * @property string $messageId
 * @property string $taskId
 * @property string $action
 * @property PushInfo $pushInfo
 * @property  string $appId
 * @property  string $appKey
 * @property  $smsInfo
 * */
class Transparent extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public  function  __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBString::class;
        $this->values["1"] = "";
        $this->fields["2"] = PBString::class;;
        $this->values["2"] = "";
        $this->fields["3"] = PBString::class;
        $this->values["3"] = "";
        $this->fields["4"] = PBString::class;
        $this->values["4"] = "";
        $this->fields["5"] = PBString::class;
        $this->values["5"] = "";
        $this->fields["6"] = PBString::class;
        $this->values["6"] = "";
        $this->fields["7"] = PushInfo::class;
        $this->values["7"] = "";
        $this->fields["8"] = ActionChain::class;
        $this->values["8"] = array();
        $this->fields["9"] = PBString::class;
        $this->values["9"] = array();
        $this->fields["10"] = PBInt::class;
        $this->values["10"] = "";
        $this->fields["11"] = PBString::class;
        $this->values["11"] = "";
        $this->fields["12"] = SmsInfo::class;
        $this->values["12"] = "";
    }
    public function  getId()
    {
        return $this->_getValue("1");
    }

    public function  setId($value)
    {
        return $this->_setValue("1", $value);
    }

    public function  getAction()
    {
        return $this->_getValue("2");
    }

    public function  setAction($value)
    {
        return $this->_setValue("2", strtolower($value));
    }
    public function  getTaskId()
    {
        return $this->_getValue("3");
    }
    public function  setTaskId($value)
    {
        return $this->_setValue("3", $value);
    }
    public function  getAppKey()
    {
        return $this->_getValue("4");
    }
    public function  setAppKey($value)
    {
        return $this->_setValue("4", $value);
    }
    public function  getAppId()
    {
        return $this->_getValue("5");
    }
    public function  setAppId($value)
    {
        return $this->_setValue("5", $value);
    }
    public function  getMessageId()
    {
        return $this->_getValue("6");
    }
    public function  setMessageId($value)
    {
        return $this->_setValue("6", $value);
    }
    public function  getPushInfo()
    {
        return $this->_getValue("7");
    }
    public function  setPushInfo($value)
    {
        return $this->_setValue("7", $value);
    }
    public function  actionChain($offset)
    {
        return $this->_getArrValue("8", $offset);
    }
    public function  addActionChain()
    {
        return $this->_addArrValue("8");
    }
    public function  setActionChain($index, $value)
    {
        $this->_setArrValue("8", $index, $value);
    }
    public function  removeLastActionChain()
    {
        $this->_removeLastArrValue("8");
    }
    public function  actionChainSize()
    {
        return $this->_getArrSize("8");
    }
    public function  getCondition($offset)
    {
        $v = $this->_getArrValue("9", $offset);
        return $v->getValue();
    }
    public function  appendCondition($value)
    {
        $v = $this->_addArrValue("9");
        $v->setValue($value);
    }
    public function  setCondition($index, $value)
    {
        $v = new $this->fields["9"]();
        $v->setValue($value);
        $this->_setArrValue("9", $index, $v);
    }
    public function  removeLastCondition()
    {
        $this->_removeLastArrValue("9");
    }
    public function  getConditionSize()
    {
        return $this->_getArrSize("9");
    }
    public function  getTemplateId()
    {
        return $this->_getValue("10");
    }
    public function  setTemplateId($value)
    {
        return $this->_setValue("10", $value);
    }
    public function  getTaskGroupId()
    {
        return $this->_getValue("11");
    }
    public function  setTaskGroupId($value)
    {
        return $this->_setValue("11", $value);
    }
    public function  getSmsInfo()
    {
        return $this->_getValue("12");
    }
    public function  setSmsInfo($value)
    {
        return $this->_setValue("12", $value);
    }
}

