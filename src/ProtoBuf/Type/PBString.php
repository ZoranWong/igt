<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/31
 * Time: 1:06 AM
 */

namespace Zoran\IGt\ProtoBuf\Type;

use Zoran\IGt\ProtoBuf\PBMessage;

class PBString extends PBScalar
{
    protected $wiredType = PBMessage::WIRED_LENGTH_DELIMITED;

    /**
     * Parses the message for this type
     *
     * @param array
     */
    public function parseFromArray()
    {
        $this->value = '';
        // first byte is length
        $length = $this->reader->next();

        // just extract the string
        $pointer = $this->reader->getPointer();
        $this->reader->addPointer($length);
        $this->value = $this->reader->getMessageFrom($pointer);
    }

    /**
     * serializes type
     * @param int $rec
     * @return string
     */
    public function serializeToString(int $rec = -1)
    {
        $string = '';

        if ($rec > -1)
        {
            $string .= $this->base128->setValue($rec << 3 | $this->wired_type);
        }

        $string .= $this->base128->setValue(strlen($this->value));
        $string .= $this->value;

        return $string;
    }
}

