<?php
namespace Payment\ManagerialBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ManagerialMemberSearch 
{
	
	/**
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/",
	 *     message = "Valor incorrecto."
	 * )
	 */
	private $name;
	
	/**
	 * @var int $offset
	 */
	private $offset;
	
	/**
	 * @var int $limit
	 */
	private $limit;
	
	
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