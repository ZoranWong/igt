<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:40 AM
 */

namespace Zoran\IGt\IGetui\Utils;

/**
 * @property string $APS
 * @property array $params
 * @property $alert
 * @property $badge
 * @property $sound
 * @property $alertBody
 * @property $alertActionLocKey
 * @property $alertLocKey
 * @property $alertLocArgs
 * @property $alertLaunchImage
 * @property $contentAvailable
 * */
class Payload
{
    protected $APS = "aps";
    protected $params;
    protected $alert;
    protected $badge;
    protected $sound = "";

    protected $alertBody;
    protected $alertActionLocKey;
    protected $alertLocKey;
    protected $alertLocArgs;
    protected $alertLaunchImage;
    protected $contentAvailable;

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->$name;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name = $value;
    }

    function addParam($key, $obj)
    {
        if ($this->params == null) {
            $this->params = array();
        }
        if ($this->APS == strtolower($key)) {
            throw new Exception("the key can't be aps");
        }
        $this->params[$key] = $obj;
    }

    function putIntoJson($key, $value, $obj)
    {
        if ($value != null) {
            $obj[$key] = $value;
        }
        return $obj;
    }

    public function __toString()
    {
        $object = array();
        $apsObj = array();
        if ($this->alert != null) {
            $apsObj["alert"] = urlencode($this->alert);
        } else {
            if ($this->alertBody != null || $this->alertLocKey != null) {
                $alertObj = array();
                $alertObj = $this->putIntoJson("body", ($this->alertBody), $alertObj);
                $alertObj = $this->putIntoJson("action-loc-key", ($this->alertActionLocKey), $alertObj);
                $alertObj = $this->putIntoJson("loc-key", ($this->alertLocKey), $alertObj);
                $alertObj = $this->putIntoJson("launch-image", ($this->alertLaunchImage), $alertObj);
                if ($this->alertLocArgs != null) {
                    $array = array();
                    foreach ($this->alertLocArgs as $str) {
                        array_push($array, ($str));
                    }
                    $alertObj["loc-args"] = $array;
                }
                $apsObj["alert"] = $alertObj;
            }
        }
        if ($this->badge != null) {
            $apsObj["badge"] = $this->badge;
        }
        // 判断是否静音
        if ("com.gexin.ios.silence" != ($this->sound)) {
            $apsObj = $this->putIntoJson("sound", ($this->sound), $apsObj);
        }
        if($this->contentAvailable == 1){
            $apsObj["content-available"]=1;
        }
        $object[$this->APS] = $apsObj;
        if ($this->params != null) {
            foreach ($this->params as $key => $value) {
                $object[($key)] = ($value);
            }
        }
        return Util::json_encode($object);
    }
}
