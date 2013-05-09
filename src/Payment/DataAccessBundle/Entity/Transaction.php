<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transaction
 */
class Transaction
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var float
     */
    private $totalValue;

    /**
     * @var \DateTime
     */
    private $systemDate;

    /**
     * @var \Payment\DataAccessBundle\Entity\Managerial
     */
    private $managerial;

    /**
     * @var \Payment\DataAccessBundle\Entity\SystemUser
     */
    private $systemUser;

    /**
     * @var \Payment\DataAccessBundle\Entity\TransactionType
     */
    private $transactionType;


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
     * Set totalValue
     *
     * @param float $totalValue
     * @return Transaction
     */
    public function setTotalValue($totalValue)
    {
        $this->totalValue = $totalValue;
    
        return $this;
    }

    /**
     * Get totalValue
     *
     * @return float 
     */
    public function getTotalValue()
    {
        return $this->totalValue;
    }

    /**
     * Set systemDate
     *
     * @param \DateTime $systemDate
     * @return Transaction
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
     * Set managerial
     *
     * @param \Payment\DataAccessBundle\Entity\Managerial $managerial
     * @return Transaction
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
     * Set systemUser
     *
     * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
     * @return Transaction
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
     * Set transactionType
     *
     * @param \Payment\DataAccessBundle\Entity\TransactionType $transactionType
     * @return Transaction
     */
    public function setTransactionType(\Payment\DataAccessBundle\Entity\TransactionType $transactionType = null)
    {
        $this->transactionType = $transactionType;
    
        return $this;
    }

    /**
     * Get transactionType
     *
     * @return \Payment\DataAccessBundle\Entity\TransactionType 
     */
    public function getTransactionType()
    {
        return $this->transactionType;
    }
    /**
     * @var integer
     */
    private $transactionTypeId;

    /**
     * @var integer
     */
    private $managerialId;

    /**
     * @var integer
     */
    private $systemUserId;


    /**
     * Set transactionTypeId
     *
     * @param integer $transactionTypeId
     * @return Transaction
     */
    public function setTransactionTypeId($transactionTypeId)
    {
        $this->transactionTypeId = $transactionTypeId;
    
        return $this;
    }

    /**
     * Get transactionTypeId
     *
     * @return integer 
     */
    public function getTransactionTypeId()
    {
        return $this->transactionTypeId;
    }

    /**
     * Set managerialId
     *
     * @param integer $managerialId
     * @return Transaction
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
     * Set systemUserId
     *
     * @param integer $systemUserId
     * @return Transaction
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
     * @var integer
     */
    private $transcationReverseId;


    /**
     * Set transcationReverseId
     *
     * @param integer $transcationReverseId
     * @return Transaction
     */
    public function setTranscationReverseId($transcationReverseId)
    {
        $this->transcationReverseId = $transcationReverseId;
    
        return $this;
    }

    /**
     * Get transcationReverseId
     *
     * @return integer 
     */
    public function getTranscationReverseId()
    {
        return $this->transcationReverseId;
    }
    /**
     * @var \Payment\DataAccessBundle\Entity\Transaction
     */
    private $transcationReverse;


    /**
     * Set transcationReverse
     *
     * @param \Payment\DataAccessBundle\Entity\Transaction $transcationReverse
     * @return Transaction
     */
    public function setTranscationReverse(\Payment\DataAccessBundle\Entity\Transaction $transcationReverse = null)
    {
        $this->transcationReverse = $transcationReverse;
    
        return $this;
    }

    /**
     * Get transcationReverse
     *
     * @return \Payment\DataAccessBundle\Entity\Transaction 
     */
    public function getTranscationReverse()
    {
        return $this->transcationReverse;
    }
}