<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:01 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\Type\PBEnum;

class InnerFiledType extends PBEnum
{
    const str  = 0;
    const int32  = 1;
    const int64  = 2;
    const floa  = 3;
    const doub  = 4;
    const bool  = 5;
}
