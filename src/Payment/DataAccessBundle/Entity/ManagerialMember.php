<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ManagerialMember
 */
class ManagerialMember
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $activationDate;

    /**
     * @var \DateTime
     */
    private $desactivationDate;

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * @var \Payment\DataAccessBundle\Entity\Charge
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el cargo."
     * )
     */
    private $charge;

    /**
     * @var \Payment\DataAccessBundle\Entity\Managerial
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la Directiva."
     * )
     */
    private $managerial;

    /**
     * @var \Payment\DataAccessBundle\Entity\Member
	 *
     */
    private $member;

    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $systemUser;

    /**
     * @var string
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el nombre."
     * ) 
     */
    private $memberName;
    
    /**
     * Set id
     *
     * @param int $id
     */
    public function setId($id)
    {
    	$this->id = $id;
    	return $this;
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set activationDate
     *
     * @param \DateTime $activationDate
     * @return ManagerialMember
     */
    public function setActivationDate($activationDate)
    {
        $this->activationDate = $activationDate;
    
        return $this;
    }

    /**
     * Get activationDate
     *
     * @return \DateTime 
     */
    public function getActivationDate()
    {
        return $this->activationDate;
    }

    /**
     * Set desactivationDate
     *
     * @param \DateTime $desactivationDate
     * @return ManagerialMember
     */
    public function setDesactivationDate($desactivationDate)
    {
        $this->desactivationDate = $desactivationDate;
    
        return $this;
    }

    /**
     * Get desactivationDate
     *
     * @return \DateTime 
     */
    public function getDesactivationDate()
    {
        return $this->desactivationDate;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return ManagerialMember
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
     * Set charge
     *
     * @param \Payment\DataAccessBundle\Entity\Charge $charge
     * @return ManagerialMember
     */
    public function setCharge(\Payment\DataAccessBundle\Entity\Charge $charge = null)
    {
        $this->charge = $charge;
    
        return $this;
    }

    /**
     * Get charge
     *
     * @return \Payment\DataAccessBundle\Entity\Charge 
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     * Set managerial
     *
     * @param \Payment\DataAccessBundle\Entity\Managerial $managerial
     * @return ManagerialMember
     */
    public function setManagerial(\Payment\DataAccessBundle\Entity\Managerial $managerial = null)
    {
        $this->managerial = $managerial;
    
        return $this;
    }

    /**
     * Get managerial
     *
     * @return \Payment\DataAccessBundle\Entity\Managerial 
     */
    public function getManagerial()
    {
        return $this->managerial;
    }

    /**
     * Set member
     *
     * @param \Payment\DataAccessBundle\Entity\Member $member
     * @return ManagerialMember
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
     * @return ManagerialMember
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
    private $managerialId;

    /**
     * @var integer
     */
    private $chargeId;

    /**
     * @var integer
     */
    private $memberId;

    /**
     * @var integer
     */
    private $systemUserId;


    /**
     * Set managerialId
     *
     * @param integer $managerialId
     * @return ManagerialMember
     */
    public function setManagerialId($managerialId)
    {
        $this->managerialId = $managerialId;
    
        return $this;
    }

    /**
     * Get managerialId
     *
     * @return integer 
     */
    public function getManagerialId()
    {
        return $this->managerialId;
    }

    /**
     * Set chargeId
     *
     * @param integer $chargeId
     * @return ManagerialMember
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;
    
        return $this;
    }

    /**
     * Get chargeId
     *
     * @return integer 
     */
    public function getChargeId()
    {
        return $this->chargeId;
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
     * Set systemUserId
     *
     * @param integer $systemUserId
     * @return ManagerialMember
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
}