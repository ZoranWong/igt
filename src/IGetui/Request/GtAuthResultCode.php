<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 2:55 PM
 */

namespace Zoran\IGt\IGetui\Request;


class GtAuthResultCode extends PBEnum
{
    const SUCCESS  = 0;
    const FAILED_NO_SIGN  = 1;
    const FAILED_NO_APP_KEY  = 2;
    const FAILED_NO_TIMESTAMP  = 3;
    const FAILED_AUTH_ILLEGAL  = 4;
    const REDIRECT  = 5;
}
