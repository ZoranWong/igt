<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:09 PM
 */

namespace Zoran\IGt\IGetui\APN;

/**
 * @property-read array $alertMsg
 * @property string $title;
 * @property array|string $body;
 * @property string $titleLocKey;
 * @property array $titleLocArgs
 * @property string $actionLocKey;
 * @property string $locKey;
 * @property array $locArgs
 * @property string $launchImage;
 * @property string $subtitle;
 * @property string $subtitleLocKey;
 * @property array $subtitleLocArgs
 * */
class DictionaryAlertMsg implements ApnMsg
{
    protected $title;
    protected $body;
    protected $titleLocKey;
    protected $titleLocArgs = [];
    protected $actionLocKey;
    protected $locKey;
    protected $locArgs = [];
    protected $launchImage;
    protected $subtitle;
    protected $subtitleLocKey;
    protected $subtitleLocArgs;

    public function getAlertMsg() {

        $alertMap = [];

        if ($this->title != null && $this->title != "") {
            $alertMap["title"] = $this->title;
        }

        if ($this->body != null && $this->body != "") {
            $alertMap["body"] = $this->body;
        }

        if ($this->titleLocKey != null && $this->titleLocKey != "") {
            $alertMap["title-loc-key"] = $this->titleLocKey;
        }

        if (sizeof($this->titleLocArgs) > 0) {
            $alertMap["title-loc-args"] = $this->titleLocArgs;
        }

        if ($this->actionLocKey != null && $this->actionLocKey) {
            $alertMap["action-loc-key"] = $this->actionLocKey;
        }

        if ($this->locKey != null && $this->locKey != "") {
            $alertMap["loc-key"] = $this->locKey;
        }

        if (sizeof($this->locArgs) > 0) {
            $alertMap["loc-args"] = $this->locArgs;
        }

        if ($this->launchImage != null && $this->launchImage != "") {
            $alertMap["launch-image"] = $this->launchImage;
        }

        if(count($alertMap) == 0) {
            return null;
        }

        if ($this->subtitle != null && $this->subtitle != "") {
            $alertMap["subtitle"] = $this->subtitle;
        }

        if (sizeof($this->subtitleLocArgs) > 0) {
            $alertMap["subtitle-loc-args"] = $this->subtitleLocArgs;
        }

        if ($this->subtitleLocKey != null && $this->subtitleLocKey != "") {
            $alertMap["subtitle-loc-key"] = $this->subtitleLocKey;
        }
        return $alertMap;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        if($name !== 'alertMsg') {
            $this->$name  = $value;
        }
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if($name !== 'alertMsg') {
            return $this->$name;
        }else {
            return $this->getAlertMsg();
        }
    }
}
