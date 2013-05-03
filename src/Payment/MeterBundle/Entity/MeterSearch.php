<?php
namespace Payment\MeterBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MeterSearch 
{
	
	/**
	 * @Assert\Regex(
	 *     pattern = "/^[0-9\-]+$/",
	 *     message = "Valor incorrecto."
	 * )
	 */
	private $accountNumber;
	
	/**
	 * @var int $offset
	 */
	private $offset;
	
	/**
	 * @var int $limit
	 */
	private $limit;
		
	/**
	 * Get accountNumber
	 *
	 * @return string
	 */
	public function getAccountNumber()
	{
		return $this->accountNumber;
	}
	
	
	/**
	 * Set accountNumber
	 *
	 * @param string $accountNumber
	 */
	public function setAccountNumber($accountNumber)
	{
		$this->accountNumber = $accountNumber;
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