<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:20 PM
 */

namespace Zoran\IGt\IGetui\Request;



use Zoran\IGt\ProtoBuf\Type\PBEnum;

class SMSStatus extends PBEnum
{
    const unread  = 0;
    const read  = 1;
}
