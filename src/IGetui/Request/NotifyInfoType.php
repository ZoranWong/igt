<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 4:37 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\Type\PBEnum;

class NotifyInfoType extends PBEnum
{
    const _payload  = 0;
    const _intent  = 1;
    const _url  = 2;
}
