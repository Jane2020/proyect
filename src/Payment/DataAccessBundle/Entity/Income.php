<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Income
 */
class Income
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Payment\DataAccessBundle\Entity\Consumption
     */
    private $consumption;


    /**
     * @var \Payment\DataAccessBundle\Entity\IncomeType
     */
    private $incomeType;

    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $systemUser;

    /**
     * @var \Payment\DataAccessBundle\Entity\Transaction
     */
    private $transaction;


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
     * Set consumption
     *
     * @param \Payment\DataAccessBundle\Entity\Consumption $consumption
     * @return Income
     */
    public function setConsumption(\Payment\DataAccessBundle\Entity\Consumption $consumption = null)
    {
        $this->consumption = $consumption;
    
        return $this;
    }

    /**
     * Get consumption
     *
     * @return \Payment\DataAccessBundle\Entity\Consumption 
     */
    public function getConsumption()
    {
        return $this->consumption;
    }

    

    /**
     * Set incomeType
     *
     * @param \Payment\DataAccessBundle\Entity\IncomeType $incomeType
     * @return Income
     */
    public function setIncomeType(\Payment\DataAccessBundle\Entity\IncomeType $incomeType = null)
    {
        $this->incomeType = $incomeType;
    
        return $this;
    }

    /**
     * Get incomeType
     *
     * @return \Payment\DataAccessBundle\Entity\IncomeType 
     */
    public function getIncomeType()
    {
        return $this->incomeType;
    }

    /**
     * Set systemUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
     * @return Income
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
     * Set transaction
     *
     * @param \Payment\DataAccessBundle\Entity\Transaction $transaction
     * @return Income
     */
    public function setTransaction(\Payment\DataAccessBundle\Entity\Transaction $transaction = null)
    {
        $this->transaction = $transaction;
    
        return $this;
    }

    /**
     * Get transaction
     *
     * @return \Payment\DataAccessBundle\Entity\Transaction 
     */
    public function getTransaction()
    {
        return $this->transaction;
    }
    /**
     * @var integer
     */
    private $incomeTypeId;

    /**
     * @var integer
     */
    private $transactionId;

    /**
     * @var integer
     */
    private $consumptionId;

    /**
     * @var integer
     */
    private $finesId;

    /**
     * @var integer
     */
    private $systemUserId;


    /**
     * Set incomeTypeId
     *
     * @param integer $incomeTypeId
     * @return Income
     */
    public function setIncomeTypeId($incomeTypeId)
    {
        $this->incomeTypeId = $incomeTypeId;
    
        return $this;
    }

    /**
     * Get incomeTypeId
     *
     * @return integer 
     */
    public function getIncomeTypeId()
    {
        return $this->incomeTypeId;
    }

    /**
     * Set transactionId
     *
     * @param integer $transactionId
     * @return Income
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    
        return $this;
    }

    /**
     * Get transactionId
     *
     * @return integer 
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * Set consumptionId
     *
     * @param integer $consumptionId
     * @return Income
     */
    public function setConsumptionId($consumptionId)
    {
        $this->consumptionId = $consumptionId;
    
        return $this;
    }

    /**
     * Get consumptionId
     *
     * @return integer 
     */
    public function getConsumptionId()
    {
        return $this->consumptionId;
    }

    /**
     * Set finesId
     *
     * @param integer $finesId
     * @return Income
     */
    public function setFinesId($finesId)
    {
        $this->finesId = $finesId;
    
        return $this;
    }


    /**
     * Set systemUserId
     *
     * @param integer $systemUserId
     * @return Income
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
    private $amount;

    /**
     * @var float
     */
    private $basicServiceUnitCost;

    /**
     * Set amount
     *
     * @param float $amount
     * @return Income
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set basicServiceUnitCost
     *
     * @param float $basicServiceUnitCost
     * @return Income
     */
    public function setBasicServiceUnitCost($basicServiceUnitCost)
    {
        $this->basicServiceUnitCost = $basicServiceUnitCost;
    
        return $this;
    }

    /**
     * Get basicServiceUnitCost
     *
     * @return float 
     */
    public function getBasicServiceUnitCost()
    {
        return $this->basicServiceUnitCost;
    }

    
    /**
     * @var \Payment\DataAccessBundle\Entity\Payment
     */
    private $payment;


    /**
     * Set payment
     *
     * @param \Payment\DataAccessBundle\Entity\Payment $payment
     * @return Income
     */
    public function setPayment(\Payment\DataAccessBundle\Entity\Payment $payment = null)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return \Payment\DataAccessBundle\Entity\Payment 
     */
    public function getPayment()
    {
        return $this->payment;
    }
}