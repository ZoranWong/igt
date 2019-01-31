<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:26 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\Type\PBEnum;

class ReqServHostResultCode extends PBEnum
{
    const SUCCESS  = 0;
    const FAILED = 1;
    const BUSY  = 2;
}
