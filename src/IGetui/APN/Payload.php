<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:04 PM
 */

namespace Zoran\IGt\IGetui\APN;


use Zoran\IGt\IGetui\Media\MultiMedia;

/**
 * @property MultiMedia[] $multiMedias
 * @property-read string $payload
 * @property array $customMsg
 * @property int $badge
 * @property string $sound
 * @property int $contentAvailable
 * @property string $category
 * @property ApnMsg $alertMsg
 * @property int $voicePlayType
 * @property string $voicePlayMessage
 * @property string $apnsCollapseId
 * @property int $autoBadge
 * */
class Payload
{
    const APN_SOUND_SILENCE = "com.gexin.ios.silence";
    const PAYLOAD_MAX_BYTES = 2048;

    protected $customMsg = [];

    protected $badge = -1;
    protected $sound  = 'default';
    protected $contentAvailable = 0;
    protected $category = null;
    /**
     * @var ApnMsg $alertMsg
     * */
    protected $alertMsg  = null;

    /**
     * @var MultiMedia[] $multiMedias
     * */
    protected $multiMedias = [];

    protected $voicePlayType = 0;
    protected $voicePlayMessage = null;

    protected $apnsCollapseId = null;
    protected $autoBadge = null;

    /**
     * @return string
     * @throws
     * */
    public function getPayload()
    {
        try {

            $apsMap = [];

            if ($this->alertMsg !== null) {
                $msg =  $this->alertMsg->getAlertMsg();
                if($msg != null) {
                    $apsMap["alert"] = $msg;
                }
            }

            if($this->autoBadge !== null) {
                $apsMap["autoBadge"] = $this->autoBadge;
            } elseif ($this->badge >= 0) {
                $apsMap["badge"] = $this->badge;
            }

            if($this -> sound === null || $this->sound === '' ) {
                $apsMap["sound"] = 'default';
            } elseif ($this->sound !== self::APN_SOUND_SILENCE) {
                $apsMap["sound"] = $this->sound;
            }

            if (sizeof($apsMap) === 0) {
                throw new \Exception("format error");
            }
            if ($this->contentAvailable > 0) {
                $apsMap["content-available"] = $this->contentAvailable;
            }

            if ($this->category !== null && $this->category !== "") {
                $apsMap["category"] = $this->category;
            }

            $map = [];
            if(count($this->customMsg) > 0) {
                foreach ($this->customMsg as $key => $value) {
                    $map[$key] = $value;
                }
            }
            $map["aps"] = $apsMap;
            if($this->apnsCollapseId !== null) {
                $map["apns-collapse-i"] = $this->apnsCollapseId;
            }
            if($this -> multiMedias !== null && sizeof($this -> multiMedias) > 0) {
                $map["_grinfo_"] = $this->getMultiMedias();
            }
            if ($this->voicePlayType == 1){
                $map["_gvp_t_"] = 1;
            } elseif ($this->voicePlayType == 2 && !empty($this->voicePlayMessage)) {
                $map["_gvp_t_"] = 2;
                $map["_gvp_m_"] = $this->voicePlayMessage;
            }
            return json_encode($map);
        } catch (\Exception $e) {
            throw new \Exception("create apn payload error", -1, $e);
        }
    }

    /**
     * @param string|int $key
     * @param MultiMedia $value
     * */
    public function addCustomMsg($key, MultiMedia $value)
    {
        if ($key !== null && $key !== "" && $value !== null) {
            $this->customMsg[$key] = $value;
        }
    }

    public function getMultiMedias()
    {
        if(sizeof($this -> multiMedias) > 3) {
            throw new \RuntimeException("MultiMedias size over limit");
        }

        $needGeneRid = false;
        $rids = array();
        for($i = 0; $i < sizeof($this -> multiMedias); $i++) {
            $media = $this -> multiMedias[$i];
            if($media ->rid === null) {
                $needGeneRid = true;
            } else {
                $rids[$media -> rid] = 0;
            }

            if($media->type === null || $media->url === null) {
                throw new \RuntimeException("MultiMedia resType and resUrl can't be null");
            }
        }

        if(sizeof($rids) !== sizeof($this -> multiMedias))  {
            $needGeneRid = true;
        }
        if($needGeneRid) {
            for ($i = 0; $i < sizeof($this->multiMedias); $i++) {
                $this->multiMedias[$i] ->rid = ("grid-" . $i);
            }
        }

        return $this -> multiMedias;
    }

    public function addMultiMedia(MultiMedia $media) {
        $this->multiMedias[] = $media;
        return $this;
    }

    function setMultiMedias($medias) {
        $this->multiMedias = $medias;
        return $this;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if($name !== 'multiMedias') {
            $this->$name  = $value;
        } else {
            $this->setMultiMedias($value);
        }
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if($name !== 'multiMedias') {
            return $this->$name;
        } else {
            return $this->getMultiMedias();
        }
    }
}
