<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:22 PM
 */

namespace Zoran\IGt\IGetui\Media;

/**
 * @property string $rid
 * @property string $url
 * @property int $type
 * @property int $onlyWifi
 * */
class MultiMedia
{
    /**
     * @protected string $rid 资源ID
     */
    protected $rid;
    /**
     * @protected string $url 资源url
     */
    protected $url;
    /**
     * @protected int $type 资源类型
     */
    protected $type;
    /**
     * @protected int $onlyWifi 是否只支持wifi下发
     */
    protected $onlyWifi = 0;

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->$name;
    }

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name  = $value;
    }
}
