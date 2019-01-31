<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:17 PM
 */

namespace Zoran\IGt\IGetui\Message;

/**
 * @property array $appIdList
 * @property string $tag
 * @property int $speed
 * */
class TagMessage extends BaseMessage
{
    protected $appIdList = null;
    protected $tag = null;
    protected $speed = 0;
}
