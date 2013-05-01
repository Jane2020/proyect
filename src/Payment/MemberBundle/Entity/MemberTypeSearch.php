<?php
namespace Payment\MemberBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class MemberTypeSearch {
	
	/**
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/",
	 *     message = "Valor incorrecto."
	 * )
	 */
	private $name;
	
	/**
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/",
	 *     message = "Valor incorrecto."
	 * )
	 */
	private $lastname;
	
	/**
	 * @Assert\Regex(
	 *     pattern = "/^[0-9\-]+$/",
	 *     message = "Valor incorrecto."
	 * )
	 */
	private $documentNumber;
	
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
	 * Set latname
	 *
	 * @param string $latname
	 */
	public function setLastName($lastname)
	{
		$this->lastname = $lastname;
	}
	
	/**
	 * Get lastname
	 *
	 * @return string
	 */
	public function getLastName()
	{
		return $this->lastname;
	}
	
	/**
	 * Get documentNumber
	 *
	 * @return string
	 */
	public function getDocumentNumber()
	{
		return $this->documentNumber;
	}
	
	
	/**
	 * Set documentNumber
	 *
	 * @param string $documentNumber
	 */
	public function setDocumentNumber($documentNumber)
	{
		$this->documentNumber = $documentNumber;
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