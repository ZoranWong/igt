<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:31 AM
 */

namespace Zoran\IGt\IGetui\Template\Notify;


class IGtNotify
{
    /**
     * 通知标题
     * @var
     */
    protected $title;

    /**
     * 通知内容
     * @var
     */
    protected $content;

    /**
     * 通知内容中携带的透传内容
     * @var
     */
    protected $payload;

    /**
     * 通知内容带url
     */
    protected $url;


    /**
     * 通知内容带intent
     */
    protected $intent;

    /**
     * 指定通知中携带的类型
     */
    protected $type;

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name = $value;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $this->$name;
    }
}
