<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 5:36 PM
 */

namespace Zoran\IGt\IGetui\Request;
use Zoran\IGt\ProtoBuf\Type\PBEnum;

class ServerNotifyType extends PBEnum
{
    const normal = 0;
    const serverListChanged = 1;
    const exception = 2;
}
