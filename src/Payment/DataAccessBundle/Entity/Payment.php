<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Payment
 */
class Payment
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $cost;

    /**
     * @var \DateTime
     */
    private $paymentDate;

    /**
     * @var boolean
     */
    private $isDeleted;

    /**
     * @var string
     */
    private $description;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $systemUser;

    /**
     * @var \Payment\DataAccessBundle\Entity\Member
     */
    private $member;

    /**
     * @var \Payment\DataAccessBundle\Entity\PaymentType
     */
    private $paymentType;
    
    private $memberId;
    
    private $memberName;
    
     /**
     * Set id
     *
     * @param integer $id
     * @return Payment
     */
    public function setId($id)
    {
        $this->id = $id;    
        return $this;
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
     * Set cost
     *
     * @param float $cost
     * @return Payment
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return float 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set paymentDate
     *
     * @param \DateTime $paymentDate
     * @return Payment
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    
        return $this;
    }

    /**
     * Get paymentDate
     *
     * @return \DateTime 
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Payment
     */
    public function setIsDeleted($isDeleted)
    {
        $this->isDeleted = $isDeleted;
    
        return $this;
    }

    /**
     * Get isDeleted
     *
     * @return boolean 
     */
    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Payment
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Payment
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set systemUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
     * @return Payment
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
     * Set member
     *
     * @param \Payment\DataAccessBundle\Entity\Member $member
     * @return Payment
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
     * Set paymentType
     *
     * @param \Payment\DataAccessBundle\Entity\PaymentType $paymentType
     * @return Payment
     */
    public function setPaymentType(\Payment\DataAccessBundle\Entity\PaymentType $paymentType = null)
    {
        $this->paymentType = $paymentType;
    
        return $this;
    }

    /**
     * Get paymentType
     *
     * @return \Payment\DataAccessBundle\Entity\PaymentType 
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }
    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $changeUser;


    /**
     * Set changeUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $changeUser
     * @return Payment
     */
    public function setChangeUser(\Payment\DataAccessBundle\Entity\SystemUser $changeUser = null)
    {
        $this->changeUser = $changeUser;
    
        return $this;
    }

    /**
     * Get changeUser
     *
     * @return \Payment\DataAccessBundle\Entity\SystemUser 
     */
    public function getChangeUser()
    {
        return $this->changeUser;
    }
    
    
    /**
     * Set memberId
     *
     * @param integer $memberId
     * @return ManagerialMember
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
}