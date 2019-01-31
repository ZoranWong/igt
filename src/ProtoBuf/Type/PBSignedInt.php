<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:28 PM
 */

namespace Zoran\IGt\ProtoBuf\Type;


use Zoran\IGt\ProtoBuf\PBMessage;

class PBSignedInt extends PBScalar
{
    var $wired_type = PBMessage::WIRED_VARINT;

    /**
     * Parses the message for this type
     *
     * @param array
     */
    public function parseFromArray()
    {
        parent::parseFromArray();

        $saved = $this->value;
        $this->value = round($this->value / 2);
        if ($saved % 2 == 1)
        {
            $this->value = -($this->value);
        }
    }

    /**
     * Serializes type
     */
    public function SerializeToString($rec=-1)
    {
        // now convert signed int to int
        $save = $this->value;
        if ($this->value < 0)
        {
            $this->value = abs($this->value)*2-1;
        }
        else
        {
            $this->value = $this->value*2;
        }
        $string = parent::SerializeToString($rec);
        // restore value
        $this->value = $save;

        return $string;
    }
}
