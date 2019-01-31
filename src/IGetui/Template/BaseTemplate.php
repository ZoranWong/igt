<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:25 PM
 */

namespace Zoran\IGt\IGetui\Template;

use Zoran\IGt\IGetui\APN\DictionaryAlertMsg;
use Zoran\IGt\IGetui\APN\Payload;
use Zoran\IGt\IGetui\Request\PushInfo;
use Zoran\IGt\IGetui\Request\SmsContentEntry;
use Zoran\IGt\IGetui\Request\SmsInfo;
use Zoran\IGt\IGetui\Request\Transparent;
use Zoran\IGt\IGetui\Template\Notify\SmsMessage;

/**
 * @property string $templateId
 * @property-read  array $actionChain
 * @property-read string $transparent
 * @property-read string $durCondition
 * @property-read string $duration
 * @property-read string $transmissionContent
 * @property-read string|null $pushType
 * @property-read PushInfo $pushInfo
 */
class BaseTemplate
{
    protected $appId = null;
    protected $appKey = null;
    protected $pushInfo = null;
    protected $duration =  null;
    protected $smsInfo =  null;

    public function getTransparent()
    {
        $transparent = new Transparent();
        $transparent->templateId = ($this->templateId);
        $transparent->id = ('');
        $transparent->messageId = ('');
        $transparent->taskId = ('');
        $transparent->action = ('pushMessage');
        $transparent->pushInfo = ($this->getPushInfo());
        $transparent->appId = ($this->appId);
        $transparent->appKey = ($this->appKkey);
        if($this->smsInfo != null){
            $transparent->smsInfo = ($this->smsInfo);
        }

        $actionChainList = $this->actionChain;

        foreach ($actionChainList as $index => $actionChain) {
            $transparent->addActionChain();
            $transparent->setActionChain($index, $actionChain);
        }

        $transparent->appendCondition($this->getDurCondition());

        return $transparent->serializeToString();
    }

    public function getActionChain()
    {
        return $list = array();
    }

    public function getDurCondition()
    {
        if ($this->duration == null || $this->duration == '')
        {
            return "";
        }
        return "duration=" . $this->duration;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param int $begin
     * @param int $end
     * @throws
     * */
    public function setDuration($begin, $end)

    {
        date_default_timezone_set('asia/shanghai');
        $ss = (string)strtotime($begin) * 1000;
        $e = (string)strtotime($end) * 1000;
        if ($ss <= 0 || $e <= 0)
            throw new \Exception("DateFormat: yyyy-MM-dd HH:mm:ss");
        if ($ss > $e)
            throw new \Exception("startTime should be smaller than endTime");

        $this->duration = $ss . "-" . $e;

    }

    public function  getTransmissionContent()
    {
        return null;
    }

    public function  getPushType()
    {
        return null;
    }


    public  function getPushInfo()
    {
        if ($this->pushInfo == null) {
            $this->pushInfo = new PushInfo();
            $this->pushInfo->invalidAPN = (true);
            $this->pushInfo->invalidMPN = (true);
        }

        return $this->pushInfo;
    }

    public function setSmsInfo(SmsMessage $smsMessage){

        if($smsMessage == null){
            throw new \RuntimeException("smsInfo cannot be empty");
        } else {
            $smsTemplateId = $smsMessage->smsTemplateId;
            $smsContent = $smsMessage->smsContent;
            $offlineSendTime = $smsMessage->offlineSendTime;
            $smsSendDuration = 0;
            if ($smsTemplateId != null || !empty($smsTemplateId)) {
                if ($offlineSendTime == null) {
                    throw new \RuntimeException("offlineSendtime cannot be empty");
                } else {
                    $build = new SmsInfo();
                    $build->smsChecked = (false);
                    $build->smsTemplateId = ($smsTemplateId);
                    $build->offlineSendTime = ($offlineSendTime);
                    if ($smsMessage->isAppLink) {

                        if ($smsContent['url'] != null) {
                            throw new \RuntimeException("SmsContent cann not contains key about url");
                        }
                        $smsContentEntry = new SmsContentEntry();
                        $smsContentEntry->key = ("applinkIdentification");
                        $smsContentEntry->value = ("1");
                        $build->setSmsContent("applinkIdentification",$smsContentEntry);
                        $payload = $smsMessage->payload;

                        if ($payload != null && !empty($payload)) {
                            $smsContentEntry = new SmsContentEntry();
                            $smsContentEntry->key = ("url");
                            $smsContentEntry->value  = ($smsMessage->url . "?n=" . $payload . "&p=");
                            $build->setSmsContent("url",$smsContentEntry);
                        } else {
                            $smsContentEntry = new SmsContentEntry();
                            $smsContentEntry->key = ("url");
                            $smsContentEntry->value = ($smsMessage->url . "?p=");
                            $build->setSmsContent("url",$smsContentEntry);
                        }
                    }
                    if ($smsContent != null) {
                        foreach ($smsContent as $key => $value) {
                            if ($key == null || empty($key) || $value == null) {
                                throw new \RuntimeException("smsContent entry cannot be null");
                            } else {
                                $smsContentEntry = new SmsContentEntry();
                                $smsContentEntry->key = ($key);
                                $smsContentEntry->value = ($value);
                                $build->setSmsContent($key, $smsContentEntry);
                            }
                        }
                    }
                    if ($smsSendDuration != null) {
                        $build->smsSendDuration = ($smsSendDuration);
                    }
                    $this->smsInfo = $build;
                }
            }
            else {
                throw new \RuntimeException("smsTemplateId cannot be empty");
            }

        }
    }

    /**
     * @param string $actionLocKey
     * @param int $badge
     * @param string $message
     * @param string $sound
     * @param string|Payload $payload
     * @param string $locKey
     * @param array $locArgs
     * @param string $launchImage
     * @param int $contentAvailable
     * @throws
     * */
    public function setPushInfo($actionLocKey, $badge, $message, $sound, $payload, $locKey, $locArgs, $launchImage, $contentAvailable = 0)
    {
        $apn = new Payload();

        $alertMsg = new DictionaryAlertMsg();
        if ($actionLocKey != null && $actionLocKey != '')
        {
            $alertMsg->actionLocKey = $actionLocKey;
        }
        if ($message != null && $message != '')
        {
            $alertMsg->body = $message;
        }
        if ($locKey != null && $locKey != '')
        {
            $alertMsg->locKey = $locKey;
        }
        if ($locArgs != null && $locArgs != '')
        {
            array_push($alertMsg->locArgs, $locArgs);
        }

        if ($launchImage != null && $launchImage != '')
        {
            $alertMsg->launchImage = $launchImage;
        }
        $apn->alertMsg = $alertMsg;

        if ($badge != null )
        {
            $apn->badge = $badge;
        }
        if ($sound != null && $sound != '')
        {
            $apn->sound = $sound;
        }
        if ($contentAvailable != null )
        {
            $apn->contentAvailable = $contentAvailable;
        }
        if ($payload != null && $payload != '')
        {
            $apn->addCustomMsg("payload", $payload);
        }
        $this->setApnInfo($apn);
    }

    /**
     * @param Payload $payload
     * @throws
     * */
    public function setApnInfo(Payload $payload)
    {
        if ($payload == null) {
            return;
        }
        $payload = $payload->payload;
        if ($payload == null || $payload == "") {
            return;
        }
        $len = strlen($payload);
        if ($len > Payload::PAYLOAD_MAX_BYTES) {
            throw new \Exception("APN payload length over length (" . $len . ">" . Payload::PAYLOAD_MAX_BYTES . ")");
        }
        $pushInfo = $this->getPushInfo();
        $pushInfo->apnJson = ($payload);
        $pushInfo->invalidAPN = (false);
    }

    public function  setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function  setAppKey($appKey)
    {
        $this->appKey = $appKey;
    }

    public function absLength($str)
    {
        if (empty($str)) {
            return 0;
        }
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, 'utf-8');
        } else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }

    public function getTemplateId() {
        if($this instanceof NotificationTemplate) {
            return 0;
        }
        if($this instanceof LinkTemplate) {
            return 1;
        }
        if($this instanceof NotyPopLoadTemplate) {
            return 2;
        }
        if($this instanceof  TransmissionTemplate) {
            return 4;
        }
        if($this instanceof APNTemplate) {
            return 5;
        }

        if($this instanceof StartActivityTemplate) {
            return 7;
        }
        return -1;
    }


}
