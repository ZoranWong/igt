<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:16 PM
 */

namespace Zoran\IGt\ProtoBuf\Type;


use Zoran\IGt\ProtoBuf\PBMessage;

class PBScalar extends PBMessage
{
    /**
     * Set scalar value
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get the scalar value
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
