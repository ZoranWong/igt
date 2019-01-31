<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:23 PM
 */

namespace Zoran\IGt\ProtoBuf\Type;


use Zoran\IGt\ProtoBuf\PBMessage;

class PBBool extends PBInt
{

    protected $wiredType = PBMessage::WIRED_VARINT;

    /**
     * Parses the message for this type
     *
     * @param array
     */
    public function parseFromArray()
    {
        $this->value = $this->reader->next();
        $this->value = ($this->value != 0) ? 1 : 0;
    }
}
