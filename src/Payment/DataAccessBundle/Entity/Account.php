<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $accountNumber;

    /**
     * @var string
     */
    private $meterNumber;

    /**
     * @var \Payment\DataAccessBundle\Entity\Member
     */
    private $member;

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
}