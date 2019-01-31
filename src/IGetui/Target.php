<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:19 PM
 */

namespace Zoran\IGt\IGetui;

/**
 * @property string $appId
 * @property string $clientId
 * @property string $alias
 * */
class Target
{
    protected $appId = null;
    protected $clientId = null;
    protected $alias = null;

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
}
