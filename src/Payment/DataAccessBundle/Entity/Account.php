<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Account
 */
class Account
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el Número de Cuenta."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[0-9\_\-]+$/",
     *     message = "Por favor ingrese correctamente el Número de Cuenta."
     * )
     */
    private $accountNumber;

    /**
     * @var string
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el Número de Medidor."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[0-9\_\-]+$/",
     *     message = "Por favor ingrese correctamente el Número de Medidor."
     * )
     */
    private $meterNumber;

    /**
     * @var \Payment\DataAccessBundle\Entity\Member
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el Nombre del Miembro."
     * )
     */
    private $member;

    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $systemUser;


    
    /**
     * Set id
     *
     * @return integer
     */
    public function setId($id)
    {
    	$this->id = $id;
    }
    
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
     * Set accountNumber
     *
     * @param integer $accountNumber
     * @return Account
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
    
        return $this;
    }

    /**
     * Get accountNumber
     *
     * @return integer 
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * Set meterNumber
     *
     * @param string $meterNumber
     * @return Account
     */
    public function setMeterNumber($meterNumber)
    {
        $this->meterNumber = $meterNumber;
    
        return $this;
    }

    /**
     * Get meterNumber
     *
     * @return string 
     */
    public function getMeterNumber()
    {
        return $this->meterNumber;
    }

    /**
     * Set member
     *
     * @param \Payment\DataAccessBundle\Entity\Member $member
     * @return Account
     */
    public function setMember(\Payment\DataAccessBundle\Entity\Member $member = null)
    {
        $this->member = $member;
    
        return $this;
    }

    /**
     * Get member
     *
     * @return \Payment\DataAccessBundle\Entity\Member 
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * Set systemUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
     * @return Account
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
    private $memberId;

    /**
     * @var integer
     */
    private $systemUserId;

    /**
     * @var boolean
     */
    private $isActive;
    
    /**
     * @var string
     */
    private $memberName;


    /**
     * Set memberId
     *
     * @param integer $memberId
     * @return Account
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    
        return $this;
    }

    /**
     * Get memberId
     *
     * @return integer 
     */
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * Set systemUserId
     *
     * @param integer $systemUserId
     * @return Account
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

    /**
     * Set memberName
     *
     * @param string $memberName
     * @return Account
     */
    public function setMemberName($memberName)
    {
    	$this->memberName = $memberName;    
    	return $this;
    }
    
    /**
     * Get memberName
     *
     * @return string
     */
    public function getMemberName()
    {
    	return $this->memberName;
    }
    
    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Account
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
     * @var \Payment\DataAccessBundle\Entity\AccountType
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el tipo de cuenta."
     * )
     */
    private $accountType;


    /**
     * Set accountType
     *
     * @param \Payment\DataAccessBundle\Entity\AccountType $accountType
     * @return Account
     */
    public function setAccountType(\Payment\DataAccessBundle\Entity\AccountType $accountType = null)
    {
        $this->accountType = $accountType;
    
        return $this;
    }

    /**
     * Get accountType
     *
     * @return \Payment\DataAccessBundle\Entity\AccountType 
     */
    public function getAccountType()
    {
        return $this->accountType;
    }
    /**
     * @var boolean
     */
    private $sewerage;


    /**
     * Set sewerage
     *
     * @param boolean $sewerage
     * @return Account
     */
    public function setSewerage($sewerage)
    {
        $this->sewerage = $sewerage;
    
        return $this;
    }

    /**
     * Get sewerage
     *
     * @return boolean 
     */
    public function getSewerage()
    {
        return $this->sewerage;
    }
}