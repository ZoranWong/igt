<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:02 PM
 */

namespace Zoran\IGt\ProtoBuf\Encoding;

/**
 * Base 128 var int - decodes and encodes base128 var int to/from decimal
 * @author Nikolai Kordulla
 */
class PBBase128
{
    // modus for output
    protected $modus = 1;

    /**
     * @param int $modus - 1=Byte 2=String
     */
    public function __construct($modus)
    {
        $this->modus = $modus;
    }


    /**
     * @param $number - number as decimal
     * @return string the base128 value of an dec value
     */
    public function setValue($number)
    {
        $string = decbin($number);
        if (strlen($string) < 8)
        {
            $hexString = dechex(bindec($string));
            if (strlen($hexString) % 2 == 1)
                $hexString = '0' . $hexString;
            if ($this->modus == 1)
            {
                return $this->hexToStr($hexString);
            }
            return $hexString;
        }

        // split it and insert the mb byte
        $string_array = array();
        $pre = '1';
        while (strlen($string) > 0)
        {
            if (strlen($string) < 8)
            {
                $string = substr('00000000', 0, 7 - strlen($string) % 7) . $string;
                $pre = '0';
            }
            $string_array[] = $pre . substr($string, strlen($string) - 7, 7);
            $string = substr($string, 0, strlen($string) - 7);
            $pre = '1';
            if ($string == '0000000')
                break;
        }

        $hexString = '';
        foreach ($string_array as $string)
        {
            $hexString .= sprintf('%02X', bindec($string));
        }

        // now format to hex string in the right format
        if ($this->modus == 1)
        {
            return $this->hexToStr($hexString);
        }

        return $hexString;
    }


    /**
     * Returns the dec value of an base128
     * @param string bstring
     * @return float|int
     */
    public function getValue($string)
    {
        // now just drop the msb and reorder it + parse it in own string
        $valueString = '';
        $string_length = strlen($string);

        $i = 1;

        while ($string_length > $i)
        {
            // unset msb string and reorder it
            $valueString = substr($string, $i, 7) . $valueString;
            $i += 8;
        }

        // now interprete it
        return bindec($valueString);
    }

    /**
     * Converts hex 2 ascii
     * @param String $hex - the hex string
     * @return string
     */
    public function hexToStr($hex)
    {
        $str = '';

        for($i = 0; $i < strlen($hex); $i += 2)
        {
            $str .= chr(hexdec(substr($hex, $i, 2)));
        }
        return $str;
    }

}
