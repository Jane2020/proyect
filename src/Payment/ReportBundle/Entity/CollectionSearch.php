<?php
namespace Payment\ReportBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class CollectionSearch 
{
	/**
	 * @var string $startDate
	 */
	private $startDate;
	
	/**
	 * @var string $endDate
	 */
	private $endDate;
	
	
	/**
	 * @var int $offset
	 */
	private $offset;
	
	/**
	 * @var int $limit
	 */
	private $limit;
	
	/**
	 * Set startDate
	 *
	 * @param string $startDate
	 */
	public function setStartDate($startDate)
	{
		$this->startDate = $startDate;
	}
	
	/**
	 * Get startDate
	 *
	 * @return string
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}
	
	/**
	 * Set endDate
	 *
	 * @param string $endDate
	 */
	public function setEndDate($endDate)
	{
		$this->endDate = $endDate;
	}
	
	/**
	 * Get endDate
	 *
	 * @return string
	 */
	public function getEndDate()
	{
		return $this->endDate;
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