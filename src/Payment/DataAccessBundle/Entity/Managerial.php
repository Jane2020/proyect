<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Managerial
 */
class Managerial
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el nombre."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\/]+$/",
     *     message = "Valor de nombre es incorrecto."
     * )
     */
    private $name;

    /**
     * @var string
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el Ruc."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[0-9]{13}$/",
     *     message = "Valor del ruc es incorrecto."
     * )
     */
    private $ruc;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var \DateTime
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la Fecha de inicio."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^\d{2,4}\-\d{1,2}\-\d{1,2}$/",
     *     message = "Valor de Fecha de inicio es incorrecto."
     * )
     */
    private $startDate;

    /**
     * @var \DateTime
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la Fecha de fin."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^\d{2,4}\-\d{1,2}\-\d{1,2}$/",
     *     message = "Valor de la Fecha de fin es incorrecto."
     * )
     */
    private $endDate;

    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $systemUser;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Managerial
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set ruc
     *
     * @param string $ruc
     * @return Managerial
     */
    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    
        return $this;
    }

    /**
     * Get ruc
     *
     * @return string 
     */
    public function getRuc()
    {
        return $this->ruc;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Managerial
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return Managerial
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    
        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return Managerial
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    
        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set systemUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
     * @return Managerial
     */
    public function setSystemUser(\Payment\DataAccessBundle\Entity\SystemUser $systemUser = null)
    {
        $this->systemUser = $systemUser;
    
        return $this;
    }

    /**
     * Get systemUser
     *
     * @return \Payment\DataAccessBundle\Entity\SystemUser 
     */
    public function getSystemUser()
    {
        return $this->systemUser;
    }
    /**
     * @var integer
     */
    private $systemUserId;


    /**
     * Set systemUserId
     *
     * @param integer $systemUserId
     * @return Managerial
     */
    public function setSystemUserId($systemUserId)
    {
        $this->systemUserId = $systemUserId;
    
        return $this;
    }

    /**
     * Get systemUserId
     *
     * @return integer 
     */
    public function getSystemUserId()
    {
        return $this->systemUserId;
    }
    
    public function setId($id)
    {
    	$this->id = $id;
    }
}