<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parameter
 */
class Parameter
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    /**
     * @var string
     */
    private $typeField;

    /**
     * @var integer
     */
    private $order;

    /**
     * @var string
     */
    private $rexType;


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
     * Set key
     *
     * @param string $key
     * @return Parameter
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return Parameter
     */
    public function setValue($value)
    {
        $this->value = $value;
    
        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set typeField
     *
     * @param string $typeField
     * @return Parameter
     */
    public function setTypeField($typeField)
    {
        $this->typeField = $typeField;
    
        return $this;
    }

    /**
     * Get typeField
     *
     * @return string 
     */
    public function getTypeField()
    {
        return $this->typeField;
    }

    /**
     * Set order
     *
     * @param integer $order
     * @return Parameter
     */
    public function setOrder($order)
    {
        $this->order = $order;
    
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set rexType
     *
     * @param string $rexType
     * @return Parameter
     */
    public function setRexType($rexType)
    {
        $this->rexType = $rexType;
    
        return $this;
    }

    /**
     * Get rexType
     *
     * @return string 
     */
    public function getRexType()
    {
        return $this->rexType;
    }
    /**
     * @var boolean
     */
    private $isActive;


    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Parameter
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
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Parameter
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
}