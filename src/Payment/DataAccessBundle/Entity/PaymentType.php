<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * PaymentType
 */
class PaymentType
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el nombre."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.]+$/",
     *     message = "Valor del nombre es incorrecto."
     * )
     */
    
    private $name;

    /**
     * @var string
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la descripción."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\,\=]+$/",
     *     message = "Valor del descripción es incorrecto."
     * )
     */
    private $description;

    /**
     * @var float
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el valor de pago."
     * )
     */
    private $cost;

    /**
     * @var boolean
     */
    private $isActive;


    /**
     * Set id
     *
     * @param string $id
     * @return PaymentType
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
     * Set name
     *
     * @param string $name
     * @return PaymentType
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
     * Set description
     *
     * @param string $description
     * @return PaymentType
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
     * Set cost
     *
     * @param float $cost
     * @return PaymentType
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return PaymentType
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
     * @var \Payment\DataAccessBundle\Entity\PaymentTypeType
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el tipo."
     * )
     *      
     */
    private $paymentTypeType;


    /**
     * Set paymentTypeType
     *
     * @param \Payment\DataAccessBundle\Entity\PaymentTypeType $paymentTypeType
     * @return PaymentType
     */
    public function setPaymentTypeType(\Payment\DataAccessBundle\Entity\PaymentTypeType $paymentTypeType = null)
    {
        $this->paymentTypeType = $paymentTypeType;
    
        return $this;
    }

    /**
     * Get paymentTypeType
     *
     * @return \Payment\DataAccessBundle\Entity\PaymentTypeType 
     */
    public function getPaymentTypeType()
    {
        return $this->paymentTypeType;
    }
}