<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:26 PM
 */

namespace Zoran\IGt\ProtoBuf\Type;
use Zoran\IGt\ProtoBuf\PBMessage;


/**
 * @author Nikolai Kordulla
 */
class PBInt extends PBScalar
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
     * @return  string
     */
    public function serializeToString(int $rec = -1)
    {
        // first byte is length byte
        $string = '';

        if ($rec > -1)
        {
            $string .= $this->base128->setValue($rec << 3 | $this->wired_type);
        }

        $value = $this->base128->setValue($this->value);
        $string .= $value;

        return $string;
    }
}
