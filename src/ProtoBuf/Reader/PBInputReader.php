<?php
/**
 * Created by PhpStorm.
 * User: wangzaron
 * Date: 2019/1/30
 * Time: 11:09 PM
 */
/**
 * Abstract class for an input reader
 */
namespace Zoran\IGt\ProtoBuf\Reader;
use Zoran\IGt\ProtoBuf\Encoding\PBBase128;

abstract class PBInputReader
{
	protected $base128;
	protected $pointer = 0;
	protected $string = '';


	public function __construct()
	{
		$this->base128 = new PBBase128(1);
	}

	/**
	 * Gets the acutal position of the point
	 * @return int the pointer
	 */
	public function getPointer()
	{
		return $this->pointer;
	}

	/**
	 * Add add to the pointer
	 * @param int $add - int to add to the pointer
	 */
	public function addPointer($add)
	{
		$this->pointer += $add;
	}

	/**
	 * Get the message from from to actual pointer
	 * @param int $from
     * @return string
	 */
	public function getMessageFrom(int $from)
	{
		return substr($this->string, $from, $this->pointer - $from);
	}

	/**
	 * Getting the next var int as decimal number
	 * @return int
	 */
	public abstract function next();
}
