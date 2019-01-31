<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:12 PM
 */

namespace Zoran\IGt\ProtoBuf\Reader;


class PBInputStringReader extends PBInputReader
{
    protected $length = 0;

    public function __construct($string)
    {
        parent::__construct();
        $this->string = $string;
        $this->length = strlen($string);
    }

    /**
     * get the next
     * @param boolean $isString - if set to true only one byte is read
     * @return int|float|boolean
     */
    public function next($isString = false)
    {
        $package = '';
        while (true)
        {
            if ($this->pointer >= $this->length)
            {
                return false;
            }

            $string = $this->string[$this->pointer];
            $this->pointer++;

            if ($isString == true)
                return ord($string);

            $value = decbin(ord($string));

            if ($value >= 10000000 && $isString == false) {
                // now fill to eight with 00
                $package .= $value;
            } else {
                // now fill to length of eight with 0
                $value = substr('00000000', 0, 8 - strlen($value) % 8) . $value;
                return $this->base128->getValue($package . $value);
            }
        }
    }
}
