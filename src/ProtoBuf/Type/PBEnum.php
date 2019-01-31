<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:16 PM
 */

namespace Zoran\IGt\ProtoBuf\Type;


use Zoran\IGt\ProtoBuf\PBMessage;

class PBEnum extends PBScalar
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
    }

    /**
     * Serializes type
     * @param int $rec
     * @return string
     */
    public function serializeToString(int $rec = -1)
    {
        $string = '';

        if ($rec > -1)
        {
            $string .= $this->base128->setValue($rec << 3 | $this->wiredType);
        }

        $value = $this->base128->setValue($this->value);
        $string .= $value;

        return $string;
    }
}
