<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 6:57 PM
 */

namespace Zoran\IGt\IGetui\Request;


use Zoran\IGt\ProtoBuf\Type\PBEnum;

class EPushResult extends PBEnum
{
    const successed_online  = 0;
    const successed_offline  = 1;
    const successed_ignore  = 2;
    const failed  = 3;
    const busy  = 4;
    const success_startBatch  = 5;
    const success_endBatch  = 6;
    const successed_async  = 7;
}
