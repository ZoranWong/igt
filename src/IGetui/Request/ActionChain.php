<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:49 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\PBMessage;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

class ActionChain extends PBMessage
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;
    public function __construct($reader=null)
    {
        parent::__construct($reader);
        $this->fields["1"] = PBInt::class;
        $this->values["1"] = "";
        $this->fields["2"] = ActionChainType::class;
        $this->values["2"] = "";
        $this->fields["3"] = PBInt::class;
        $this->values["3"] = "";
        $this->fields["100"] = PBString::class;
        $this->values["100"] = "";
        $this->fields["101"] =  PBString::class;
        $this->values["101"] = "";
        $this->fields["102"] =  PBString::class;
        $this->values["102"] = "";
        $this->fields["103"] =  PBString::class;
        $this->values["103"] = "";
        $this->fields["104"] =  PBBool::class;
        $this->values["104"] = "";
        $this->fields["105"] =  PBBool::class;
        $this->values["105"] = "";
        $this->fields["106"] =  PBBool::class;
        $this->values["106"] = "";
        $this->fields["107"] =  PBString::class;
        $this->values["107"] = "";
        $this->fields["120"] =  PBString::class;
        $this->values["120"] = "";
        $this->fields["121"] = Button::class;
        $this->values["121"] = [];
        $this->fields["140"] =  PBString::class;
        $this->values["140"] = "";
        $this->fields["141"] = AppStartUp::class;
        $this->values["141"] = "";
        $this->fields["142"] =  PBBool::class;
        $this->values["142"] = "";
        $this->fields["143"] = PBInt::class;
        $this->values["143"] = "";
        $this->fields["160"] =  PBString::class;
        $this->values["160"] = "";
        $this->fields["161"] =  PBString::class;
        $this->values["161"] = "";
        $this->fields["162"] =  PBBool::class;
        $this->values["162"] = "";
        $this->values["162"] = new PBBool();
        $this->values["162"]->value = false;
        $this->fields["180"] =  PBString::class;
        $this->values["180"] = "";
        $this->fields["181"] =  PBString::class;
        $this->values["181"] = "";
        $this->fields["182"] = PBInt::class;
        $this->values["182"] = "";
        $this->fields["183"] = SMSStatus::class;
        $this->values["183"] = "";
        $this->fields["200"] = PBInt::class;
        $this->values["200"] = "";
        $this->fields["201"] = PBInt::class;
        $this->values["201"] = "";
        $this->fields["220"] =  PBString::class;
        $this->values["220"] = "";
        $this->fields["223"] =  PBBool::class;
        $this->values["223"] = "";
        $this->fields["225"] =  PBBool::class;
        $this->values["225"] = "";
        $this->fields["226"] =  PBBool::class;
        $this->values["226"] = "";
        $this->fields["227"] =  PBBool::class;
        $this->values["227"] = "";
        $this->fields["241"] =  PBString::class;
        $this->values["241"] = "";
        $this->fields["242"] =  PBString::class;
        $this->values["242"] = "";
        $this->fields["260"] =  PBBool::class;
        $this->values["260"] = "";
        $this->fields["280"] =  PBString::class;
        $this->values["280"] = "";
        $this->fields["281"] =  PBString::class;
        $this->values["281"] = "";
        $this->fields["300"] =  PBBool::class;
        $this->values["300"] = "";
        $this->fields["320"] =  PBString::class;
        $this->values["320"] = "";
        $this->fields["340"] = PBInt::class;
        $this->values["340"] = "";
        $this->fields["360"] =  PBString::class;
        $this->values["360"] = "";
        $this->fields["380"] =  PBString::class;
        $this->values["380"] = "";
        $this->fields["381"] = InnerFiled::class;
        $this->values["381"] = [];
        $this->fields["382"] =  PBString::class;
        $this->values["382"] = "";
        $this->fields["383"] =  PBBool::class;
        $this->values["383"] = "";
    }
    public function getActionId()
    {
        return $this->_getValue("1");
    }
    public function setActionId($value)
    {
        return $this->_setValue("1", $value);
    }
    public function getType()
    {
        return $this->_getValue("2");
    }
    public function setType($value)
    {
        return $this->_setValue("2", $value);
    }
    public function getNext()
    {
        return $this->_getValue("3");
    }
    public function setNext($value)
    {
        return $this->_setValue("3", $value);
    }
    public function getLogo()
    {
        return $this->_getValue("100");
    }
    public function setLogo($value)
    {
        return $this->_setValue("100", $value);
    }
    public function getLogoURL()
    {
        return $this->_getValue("101");
    }
    public function setLogoURL($value)
    {
        return $this->_setValue("101", $value);
    }
    public function getTitle()
    {
        return $this->_getValue("102");
    }
    public function setTitle($value)
    {
        return $this->_setValue("102", $value);
    }
    public function getText()
    {
        return $this->_getValue("103");
    }
    public function setText($value)
    {
        return $this->_setValue("103", $value);
    }
    public function getClearable()
    {
        return $this->_getValue("104");
    }
    public function setClearable($value)
    {
        return $this->_setValue("104", $value);
    }
    public function getRing()
    {
        return $this->_getValue("105");
    }
    public function setRing($value)
    {
        return $this->_setValue("105", $value);
    }
    public function getBuzz()
    {
        return $this->_getValue("106");
    }
    public function setBuzz($value)
    {
        return $this->_setValue("106", $value);
    }
    public function getBannerURL()
    {
        return $this->_getValue("107");
    }
    public function setBannerURL($value)
    {
        return $this->_setValue("107", $value);
    }
    public function getImg()
    {
        return $this->_getValue("120");
    }
    public function setImg($value)
    {
        return $this->_setValue("120", $value);
    }

    public function getButtons($offset)
    {
        return $this->_getArrValue("121", $offset);
    }
    public function addButtons()
    {
        return $this->_addArrValue("121");
    }

    public function setButtons($index, $value)
    {
        $this->_setArrValue("121", $index, $value);
    }

    public function removeLastButtons()
    {
        $this->_removeLastArrValue("121");
    }

    public function buttonsSize()
    {
        return $this->_getArrSize("121");
    }

    public function getAppId()
    {
        return $this->_getValue("140");
    }
    public function setAppId($value)
    {
        return $this->_setValue("140", $value);
    }
    public function getAppStartupId()
    {
        return $this->_getValue("141");
    }
    public function setAppStartupId($value)
    {
        return $this->_setValue("141", $value);
    }
    public function getAutoStart()
    {
        return $this->_getValue("142");
    }
    public function setAutoStart($value)
    {
        return $this->_setValue("142", $value);
    }
    public function getFailedAction()
    {
        return $this->_getValue("143");
    }
    public function setFailedAction($value)
    {
        return $this->_setValue("143", $value);
    }
    public function getUrl()
    {
        return $this->_getValue("160");
    }
    public function setUrl($value)
    {
        return $this->_setValue("160", $value);
    }
    public function getWithCid()
    {
        return $this->_getValue("161");
    }
    public function setWithCid($value)
    {
        return $this->_setValue("161", $value);
    }
    public function getIsWithNetType()
    {
        return $this->_getValue("162");
    }
    public function setIsWithNetType($value)
    {
        return $this->_setValue("162", $value);
    }
    public function getAddress()
    {
        return $this->_getValue("180");
    }
    public function setAddress($value)
    {
        return $this->_setValue("180", $value);
    }
    public function getContent()
    {
        return $this->_getValue("181");
    }
    public function setContent($value)
    {
        return $this->_setValue("181", $value);
    }
    public function getCt()
    {
        return $this->_getValue("182");
    }
    public function setCt($value)
    {
        return $this->_setValue("182", $value);
    }
    public function getFlag()
    {
        return $this->_getValue("183");
    }
    public function setFlag($value)
    {
        return $this->_setValue("183", $value);
    }
    public function getSuccessAction()
    {
        return $this->_getValue("200");
    }
    public function setSuccessAction($value)
    {
        return $this->_setValue("200", $value);
    }
    public function getUninstalledAction()
    {
        return $this->_getValue("201");
    }
    public function setUninstalledAction($value)
    {
        return $this->_setValue("201", $value);
    }
    public function getName()
    {
        return $this->_getValue("220");
    }
    public function setName($value)
    {
        return $this->_setValue("220", $value);
    }
    public function getAutoInstall()
    {
        return $this->_getValue("223");
    }
    public function setAutoInstall($value)
    {
        return $this->_setValue("223", $value);
    }
    public function getWifiAutoDownload()
    {
        return $this->_getValue("225");
    }
    public function setWifiAutoDownload($value)
    {
        return $this->_setValue("225", $value);
    }
    public function getForceDownload()
    {
        return $this->_getValue("226");
    }
    public function setForceDownload($value)
    {
        return $this->_setValue("226", $value);
    }
    public function getShowProgress()
    {
        return $this->_getValue("227");
    }
    public function setShowProgress($value)
    {
        return $this->_setValue("227", $value);
    }
    public function getPost()
    {
        return $this->_getValue("241");
    }
    public function setPost($value)
    {
        return $this->_setValue("241", $value);
    }
    public function getHeaders()
    {
        return $this->_getValue("242");
    }
    public function setHeaders($value)
    {
        return $this->_setValue("242", $value);
    }
    public function getGroupable()
    {
        return $this->_getValue("260");
    }
    public function setGroupable($value)
    {
        return $this->_setValue("260", $value);
    }
    public function getMmsTitle()
    {
        return $this->_getValue("280");
    }
    public function setMmsTitle($value)
    {
        return $this->_setValue("280", $value);
    }
    public function getMmsURL()
    {
        return $this->_getValue("281");
    }
    public function setMmsURL($value)
    {
        return $this->_setValue("281", $value);
    }
    public function getPreload()
    {
        return $this->_getValue("300");
    }
    public function setPreload($value)
    {
        return $this->_setValue("300", $value);
    }
    public function getTaskId()
    {
        return $this->_getValue("320");
    }
    public function setTaskId($value)
    {
        return $this->_setValue("320", $value);
    }
    public function getDuration()
    {
        return $this->_getValue("340");
    }
    public function setDuration($value)
    {
        return $this->_setValue("340", $value);
    }
    public function getDate()
    {
        return $this->_getValue("360");
    }
    public function setDate($value)
    {
        return $this->_setValue("360", $value);
    }
    public function getStype()
    {
        return $this->_getValue("380");
    }
    public function setStype($value)
    {
        return $this->_setValue("380", $value);
    }
    public function field($offset)
    {
        return $this->_get_arr_value("381", $offset);
    }
    public function addField()
    {
        return $this->_addArrValue("381");
    }
    public function setField($index, $value)
    {
        $this->_setArrValue("381", $index, $value);
    }
    public function removeLastField()
    {
        $this->_removeLastArrValue("381");
    }
    public function fieldSize()
    {
        return $this->_getArrSize("381");
    }
    public function getNotifyId()
    {
        return $this->_getValue("382");
    }
    public function setNotifyId($value)
    {
        return $this->_setValue("382", $value);
    }
    public function getForce()
    {
        return $this->_getValue("383");
    }
    public function setForce($value)
    {
        return $this->_setValue("383", $value);
    }
}
