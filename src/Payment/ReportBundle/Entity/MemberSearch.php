<?php
namespace Payment\ReportBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MemberSearch 
{
	
	/**
	 * @var int $order
	 */
	private $order;
	
	/**
	 * @var int $to
	 */
	private $to;
	
	/**
	 * @var int $from
	 */
	private $from;
	
	/**
	 * @var int $offset
	 */
	private $offset;
	
	/**
	 * @var int $limit
	 */
	private $limit;
	
	
	/**
	 * Set order
	 *
	 * @param string $order
	 */
	public function setOrder($order)
	{
		$this->order = $order;
	}
	
	/**
	 * Get order
	 *
	 * @return string
	 */
	public function getOrder()
	{
		return $this->order;
	}
	
	/**
	 * Set to
	 *
	 * @param string $to
	 */
	public function setTo($to)
	{
		$this->to = $to;
	}
	
	/**
	 * Get to
	 *
	 * @return string
	 */
	public function getTo()
	{
		return $this->to;
	}
	
	/**
	 * Set from
	 *
	 * @param string $from
	 */
	public function setFrom($from)
	{
		$this->from = $from;
	}
	
	/**
	 * Get from
	 *
	 * @return string
	 */
	public function getFrom()
	{
		return $this->from;
	}
	
	/**
	 * Set offset
	 *
	 * @param int $offset
	 */
	public function setOffset($offset)
	{
		$this->offset = $offset;
	}
	
	/**
	 * Get offset
	 *
	 * @return int
	 */
	public function getOffset()
	{
		return $this->offset;
	}
	/**
	 * Set limit
	 *
	 * @param int $limit
	 */
	public function setLimit($limit)
	{
		$this->limit = $limit;
	}
	
	/**
	 * Get limit
	 *
	 * @return int
	 */
	public function getLimit()
	{
		return $this->limit;
	}
}