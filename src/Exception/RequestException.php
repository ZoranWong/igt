<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 10:57 PM
 */
namespace Zoran\IGt\Exception;

class RequestException extends \Exception
{
    protected $requestId;

    public function __construct($requestId, $message, $e)
    {
        parent::__construct($message, $e);
        $this->requestId = $requestId;
    }
    public function getRequestId()
    {
        return $this->requestId;
    }
}
