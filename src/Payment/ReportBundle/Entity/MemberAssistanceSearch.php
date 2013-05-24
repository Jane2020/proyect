<?php
namespace Payment\ReportBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MemberAssistanceSearch 
{
	
	/**
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/",
	 *     message = "Valor incorrecto."
	 * )
	 */
	private $name;
	
	/**
	 * @var string $paymentType 
     */
	private $paymentType;
	
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
	 * Set paymentType
	 *
	 * @param string $paymentType
	 */
	public function setPaymentType($paymentType)
	{
		$this->paymentType = $paymentType;
	}
	
	/**
	 * Get paymentType
	 *
	 * @return string
	 */
	public function getPaymentType()
	{
		return $this->paymentType;
	}
	
	/**
	 * Set name
	 *
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Get name
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}
	
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