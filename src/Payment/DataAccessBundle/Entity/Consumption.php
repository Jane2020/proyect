<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consumption
 */
class Consumption
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $costValue;

    /**
     * @var \DateTime
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la Fecha de lectura."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^\d{2,4}\-\d{1,2}\-\d{1,2}$/",
     *     message = "Valor de Fecha de lectura es incorrecto."
     */
    private $readDate;

    /**
     * @var \DateTime
     */
    private $systemDate;

    /**
     * @var \Payment\DataAccessBundle\Entity\Account
     */
    private $account;

    /**
     * @var \Payment\DataAccessBundle\Entity\ServiceCost
     */
    private $cost;

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
     * Set costValue
     *
     * @param float $costValue
     * @return Consumption
     */
    public function setCostValue($costValue)
    {
        $this->costValue = $costValue;
    
        return $this;
    }

    /**
     * Get costValue
     *
     * @return float 
     */
    public function getCostValue()
    {
        return $this->costValue;
    }

    /**
     * Set readDate
     *
     * @param \DateTime $readDate
     * @return Consumption
     */
    public function setReadDate($readDate)
    {
        $this->readDate = $readDate;
    
        return $this;
    }

    /**
     * Get readDate
     *
     * @return \DateTime 
     */
    public function getReadDate()
    {
        return $this->readDate;
    }

    /**
     * Set systemDate
     *
     * @param \DateTime $systemDate
     * @return Consumption
     */
    public function setSystemDate($systemDate)
    {
        $this->systemDate = $systemDate;
    
        return $this;
    }

    /**
     * Get systemDate
     *
     * @return \DateTime 
     */
    public function getSystemDate()
    {
        return $this->systemDate;
    }

    /**
     * Set account
     *
     * @param \Payment\DataAccessBundle\Entity\Account $account
     * @return Consumption
     */
    public function setAccount(\Payment\DataAccessBundle\Entity\Account $account = null)
    {
        $this->account = $account;
    
        return $this;
    }

    /**
     * Get account
     *
     * @return \Payment\DataAccessBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set cost
     *
     * @param \Payment\DataAccessBundle\Entity\ServiceCost $cost
     * @return Consumption
     */
    public function setCost(\Payment\DataAccessBundle\Entity\ServiceCost $cost = null)
    {
        $this->cost = $cost;
    
        return $this;
    }

    /**
     * Get cost
     *
     * @return \Payment\DataAccessBundle\Entity\ServiceCost 
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set systemUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
     * @return Consumption
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
    private $costId;

    /**
     * @var integer
     */
    private $accountId;

    /**
     * @var integer
     */
    private $systemUserId;


    /**
     * Set costId
     *
     * @param integer $costId
     * @return Consumption
     */
    public function setCostId($costId)
    {
        $this->costId = $costId;
    
        return $this;
    }

    /**
     * Get costId
     *
     * @return integer 
     */
    public function getCostId()
    {
        return $this->costId;
    }

    /**
     * Set accountId
     *
     * @param integer $accountId
     * @return Consumption
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;
    
        return $this;
    }

    /**
     * Get accountId
     *
     * @return integer 
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Set systemUserId
     *
     * @param integer $systemUserId
     * @return Consumption
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
     * @var float
     */
    private $consumptionValue;

    /**
     * @var integer
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la lectura del medidor."
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[0-9]{11}$/",
     *     message = "Valor de la lectura del medidor es incorrecto."
     * )
     */
    private $meterCurrentReading;

    /**
     * @var integer
     */
    private $meterPreviousReadingId;

    /**
     * @var string
     * 
      * @Assert\Regex(
     *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/",
     *     message = "Valor de la descripcion es incorrecto."
     * )
     */
    private $description;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var boolean
     */
    private $isDeleted;


    /**
     * Set consumptionValue
     *
     * @param float $consumptionValue
     * @return Consumption
     */
    public function setConsumptionValue($consumptionValue)
    {
        $this->consumptionValue = $consumptionValue;
    
        return $this;
    }

    /**
     * Get consumptionValue
     *
     * @return float 
     */
    public function getConsumptionValue()
    {
        return $this->consumptionValue;
    }

    /**
     * Set meterCurrentReading
     *
     * @param integer $meterCurrentReading
     * @return Consumption
     */
    public function setMeterCurrentReading($meterCurrentReading)
    {
        $this->meterCurrentReading = $meterCurrentReading;
    
        return $this;
    }

    /**
     * Get meterCurrentReading
     *
     * @return integer 
     */
    public function getMeterCurrentReading()
    {
        return $this->meterCurrentReading;
    }

    /**
     * Set meterPreviousReadingId
     *
     * @param integer $meterPreviousReadingId
     * @return Consumption
     */
    public function setMeterPreviousReadingId($meterPreviousReadingId)
    {
        $this->meterPreviousReadingId = $meterPreviousReadingId;
    
        return $this;
    }

    /**
     * Get meterPreviousReadingId
     *
     * @return integer 
     */
    public function getMeterPreviousReadingId()
    {
        return $this->meterPreviousReadingId;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Consumption
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
     * @return Consumption
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
     * Set isDeleted
     *
     * @param boolean $isDeleted
     * @return Consumption
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
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $changeUser;

    /**
     * @var \Payment\DataAccessBundle\Entity\Consumption
     */
    private $meterPreviousReading;


    /**
     * Set changeUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $changeUser
     * @return Consumption
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
     * Set meterPreviousReading
     *
     * @param \Payment\DataAccessBundle\Entity\Consumption $meterPreviousReading
     * @return Consumption
     */
    public function setMeterPreviousReading(\Payment\DataAccessBundle\Entity\Consumption $meterPreviousReading = null)
    {
        $this->meterPreviousReading = $meterPreviousReading;
    
        return $this;
    }

    /**
     * Get meterPreviousReading
     *
     * @return \Payment\DataAccessBundle\Entity\Consumption 
     */
    public function getMeterPreviousReading()
    {
        return $this->meterPreviousReading;
    }
}