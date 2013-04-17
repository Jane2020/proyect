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
}
