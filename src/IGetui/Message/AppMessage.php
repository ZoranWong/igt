<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 3:35 PM
 */

namespace Zoran\IGt\IGetui\Message;

use Zoran\IGt\IGetui\Utils\AppConditions;
/**
 * @property TagMessage[] $tagList
 * @property AppConditions $conditions
 * @property int $speed
 * @property int $pushTime
 * @property array $provinceList
 * @property array $appIdList
 * @property array $phoneTypeList
 * */
class AppMessage extends BaseMessage
{
    //array('','',..)
    protected $appIdList;
    //array('','',..)
    protected $phoneTypeList;
    //array('','',..)
    protected $provinceList;

    /**
     * @var array $tagList
     * */
    protected $tagList;

    /**
     * @var AppConditions $conditions
     * */
    protected $conditions;

    /**
     * @var int $speed
     * */
    protected $speed=0;

    /**
     * @var integer $pushTime
     * */
    protected $pushTime;
}
