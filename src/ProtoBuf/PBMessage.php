<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:00 PM
 */

namespace Zoran\IGt\ProtoBuf;


use Zoran\IGt\ProtoBuf\Encoding\PBBase128;
use Zoran\IGt\ProtoBuf\Reader\PBInputReader;
use Zoran\IGt\ProtoBuf\Reader\PBInputStringReader;
use Zoran\IGt\ProtoBuf\Type\PBBool;
use Zoran\IGt\ProtoBuf\Type\PBBytes;
use Zoran\IGt\ProtoBuf\Type\PBEnum;
use Zoran\IGt\ProtoBuf\Type\PBInt;
use GuzzleHttp\Client;
use Zoran\IGt\ProtoBuf\Type\PBSignedInt;
use Zoran\IGt\ProtoBuf\Type\PBString;

abstract class PBMessage
{
    const WIRED_VARINT = 0;
    const WIRED_64BIT = 1;
    const WIRED_LENGTH_DELIMITED = 2;
    const WIRED_START_GROUP = 3;
    const WIRED_END_GROUP = 4;
    const WIRED_32BIT = 5;

    /**
     * @var PBBase128
     * */
    protected $base128;

    // here are the field types
    protected $fields = [];
    // the values for the fields
    protected $values = [];

    // type of the class
    protected $wiredType = 2;

    protected $value = null;

    // now use pointer for speed improvement
    // pointer to begin
    /**
     * @var PBInputReader
     * */
    protected $reader = null;

    // modus byte or string parse (byte for productive string for better reading and debuging)
    // 1 = byte, 2 = String
    const MODUS = 1;

    // chunk which the class not understands
    var $chunk = '';

    // variable for Send method
    var $_dString = '';

    /**
     * @param PBBase128 $reader
     * */
    public function __construct($reader = null)
    {
        $this->reader = $reader;
        $this->value = $this;
        $this->base128 = new PBBase128(PBMessage::MODUS);
    }

    /**
     * Get the wired_type and field_type
     * @param $number as decimal
     * @return array wired_type, field_type
     */
    public function getTypes($number)
    {
        $binString = decbin($number);
        $types = [];
        $low = substr($binString, strlen($binString) - 3, strlen($binString));
        $types['wired'] = bindec($low);
        $types['field'] = bindec($binString) >> 3;
        return $types;
    }


    /**
     * Encodes a Message
     * @param int $rec
     * @return string the encoded message
     */
    public function serializeToString(int $rec = -1)
    {
        $string = '';
        // wired and type
        if ($rec > -1) {
            $string .= $this->base128->setValue($rec << 3 | $this->wiredType);
        }

        $stringInner = '';

        foreach ($this->fields as $index => $field) {
            if (is_array($this->values[$index]) && count($this->values[$index]) > 0) {
                // make serialization for every array
                /** @var PBMessage $pbMessage */
                foreach ($this->values[$index] as $pbMessage) {
                    $newString = '';
                    $newString .= $pbMessage->serializeToString($index);

                    $stringInner .= $newString;
                }
            } else if ($this->values[$index] != null) {
                // wired and type
                $newString = '';
                /** @var PBMessage $pbMessage */
                $pbMessage = $this->values[$index];
                $newString .= $pbMessage->serializeToString($index);

                $stringInner .= $newString;
            }
        }

        $this->serializeChunk($stringInner);

        if ($this->wiredType == PBMessage::WIRED_LENGTH_DELIMITED && $rec > -1) {
            $stringInner = $this->base128->setValue(strlen($stringInner) / PBMessage::MODUS) . $stringInner;
        }

        return $string . $stringInner;
    }

    /**
     * Serializes the chunk
     * @param String $stringInner - String where to append the chunk
     */
    public function serializeChunk(&$stringInner)
    {
        $stringInner .= $this->chunk;
    }

    /**
     * Decodes a Message and Built its things
     * @param string $message
     * @throws
     */
    public function parseFromString($message)
    {
        $this->reader = new PBInputStringReader($message);
        $this->_parseFromArray();
    }

    /**
     * Internal function
     * @throws
     */
    public function parseFromArray()
    {
        $this->chunk = '';
        // read the length byte
        $length = $this->reader->next();
        // just take the splice from this array
        $this->_parseFromArray($length);
    }

    /**
     * Internal function
     * @param int $length
     * @throws
     */
    private function _parseFromArray($length = 99999999)
    {
        $_begin = $this->reader->getPointer();
        while ($this->reader->getPointer() - $_begin < $length) {
            $next = $this->reader->next();
            if ($next === false)
                break;

            // now get the message type
            $messTypes = $this->getTypes($next);

            // now make method test
            if (!isset($this->fields[$messTypes['field']])) {
                // field is unknown so just ignore it
                // throw new Exception('Field ' . $messTypes['field'] . ' not present ');
                if ($messTypes['wired'] == PBMessage::WIRED_LENGTH_DELIMITED) {
                    $consume = new PBString($this->reader);
                } else if ($messTypes['wired'] == PBMessage::WIRED_VARINT) {
                    $consume = new PBInt($this->reader);
                } else {
                    throw new \Exception('I dont understand this wired code:' . $messTypes['wired']);
                }

                // perhaps send a warning out
                // @TODO SEND CHUNK WARNING
                $_oldPointer = $this->reader->getPointer();
                $consume->parseFromArray();
                // now add array from _oldPointer to pointer to the chunk array
                $this->chunk .= $this->reader->getMessageFrom($_oldPointer);
                continue;
            }

            // now array or not
            /** @var PBMessage $pBMessage */
            $pBMessage = $this->getPBMessage($this->fields[$messTypes['field']], $this->reader);
            if (is_array($this->values[$messTypes['field']])) {

                $this->values[$messTypes['field']][] = $pBMessage;
                if ($messTypes['wired'] != $pBMessage->wiredType) {
                    throw new \Exception('Expected type:' . $messTypes['wired'] . ' but had ' . $pBMessage->wiredType);
                }
            } else {
                $this->values[$messTypes['field']] = $pBMessage;
                if ($messTypes['wired'] != $pBMessage->wiredType) {
                    throw new \Exception('Expected type:' . $messTypes['wired'] . ' but had ' . $pBMessage->wiredType);
                }
            }
            if($pBMessage) {
                $pBMessage->parseFromArray();
            }
        }
    }

    /**
     * @param string $type
     * @param
     *
     * @return null|PBBool|PBBytes|PBEnum|PBInt|PBSignedInt|PBString
     */
    protected function getPBMessage($type, $reader)
    {
        switch ($type) {
            case PBString::class: {
                return new PBString($reader);
            }
            case PBInt::class: {
                return new PBInt($reader);
            }
            case PBBool::class: {
                return new PBBool($reader);
            }
            case PBSignedInt::class: {
                return new PBSignedInt($reader);
            }
            case PBEnum::class: {
                return new PBEnum($reader);
            }
            case PBBytes::class: {
                return new PBBytes($reader);
            }
        }
        return null;
    }

    /**
     * Add an array value
     * @param int - index of the field
     * @return mixed
     */
    protected function _addArrValue($index)
    {
        return $this->values[$index][] = new $this->fields[$index]();
    }

    /**
     * Set an array value - @TODO failure check
     * @param int - index of the field
     * @param int - index of the array
     * @param object - the value
     */
    protected function _setArrValue($index, $index_arr, $value)
    {
        $this->values[$index][$index_arr] = $value;
    }

    /**
     * Remove the last array value
     * @param int - index of the field
     */
    protected function _removeLastArrValue($index)
    {
        array_pop($this->values[$index]);
    }

    /**
     * Set an value
     * @param int - index of the field
     * @param Mixed value
     */
    protected function _setValue($index, $value)
    {
        if (gettype($value) == 'object') {
            $this->values[$index] = $value;
        } else {
            $this->values[$index] = new $this->fields[$index]();
            $this->values[$index]->value = $value;
        }
    }

    /**
     * Get a value
     * @param int $index id of the field
     * @return mixed|null
     */
    protected function _getValue($index)
    {
        if ($this->values[$index] == null)
            return null;
        return $this->values[$index]->value;
    }

    /**
     * Get array value
     * @param int $index id of the field
     * @param value
     * @return  mixed
     */
    protected function _getArrValue($index, $value)
    {
        return $this->values[$index][$value];
    }

    /**
     * Get array size
     * @param int $index id of the field
     * @return int
     */
    protected function _getArrSize($index)
    {
        return count($this->values[$index]);
    }

    /**
     * Sends the message via post request ['message'] to the url
     * @param string $url the url
     * @param PBMessage $class the PBMessage class where the request should be encoded
     *
     * @return String - the return string from the request to the url
     */
    public function send($url, &$class = null)
    {
        $httpClient = new Client();
        $result = $httpClient->request('POST', $url, ['message' => $this->serializeToString()]);
        $this->_dString = $result->getBody();
        if ($class != null)
            $class->parseFromString($this->_dString);
        return $this->_dString;
    }

    /**
     * Fix Memory Leaks with Objects in PHP 5
     * http://paul-m-jones.com/?p=262
     *
     * thanks to cheton
     * http://code.google.com/p/pb4php/issues/detail?id=3&can=1
     */
    public function _destruct()
    {
        if (isset($this->reader)) {
            unset($this->reader);
        }

        if (isset($this->value)) {
            unset($this->value);
        }

        // base128
        if (isset($this->base128)) {
            unset($this->base128);
        }

        // fields
        if (isset($this->fields)) {
            foreach ($this->fields as $name => $value) {
                unset($this->$name);
            }
            unset($this->fields);
        }

        // values
        if (isset($this->values)) {
            foreach ($this->values as $name => $value) {
                if (is_array($value)) {
                    foreach ($value as $name2 => $value2) {
                        if (is_object($value2) AND method_exists($value2, '__destruct')) {
                            $value2->__destruct();
                        }
                        unset($value2);
                    }

                    if (isset($name2))
                        unset($value->$name2);
                } else {
                    if (is_object($value) AND method_exists($value, '__destruct')) {
                        $value->__destruct();
                    }
                    unset($value);
                }
                unset($this->values->$name);
            }
            unset($this->values);
        }
    }
}
