<?php

namespace Payment\DataAccessBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Member
 */
class Member
{
    /**
     * @var integer
     */
    public $id;

     /**
     * @var string
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese la cédula de identidad."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^(?:\+)?\d{10}$/",
     *     message = "Por favor ingrese 10 dígitos."
     * )
     */
    private $documentNumber;

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
     *   message = "Por favor ingrese el apellido."
     * )
     * 
     * @Assert\Regex(
     *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.]+$/",
     *     message = "Valor del apellido es incorrecto."
     * )
     */
    private $lastname;

    /**
     * @var \DateTime
     * 
     */
    private $birthDate;

    /**
     * @var string
     * 
     * @Assert\Regex(
     *     pattern = "/^[a-zA-Z0-9ÁÉÍÓÚÑáéíóúñ\s\,\.\:\;\-\#]+$/",
     *     message = "Valor de la dirección es incorrecta." 
     * )    
     */
    private $address;

    /**
     * @var string
     * 
     * @Assert\Regex(
     *     pattern = "/^(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]\.?){0,63}[a-z0-9!#$%&'*+\/=?^_`{|}~-]@(?:(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)*[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\])$/i",
     *     message = "Valor del e-mail es incorrecto." 
     * )  
     */
    private $email;

    /**
     * @var string
     * 
     *
     * @Assert\Regex(
     *     pattern = "/^(?:\+)?\d{9}$/",
     *     message = "Por favor ingrese 9 dígitos." 
     * )  
     */
    private $phone;

    /**
     * @var string
     * 
     * @Assert\NotBlank(
     *   message = "Por favor ingrese el número de celular."
     * ) 
     * 
     * @Assert\Regex(
     *     pattern = "/^(?:\+)?\d{10}$/",
     *     message = "Por favor ingrese 10 dígitos." 
     * ) 
     */
    private $celularPhone;


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
     * Set documentNumber
     *
     * @param string $documentNumber
     * @return Member
     */
    public function setDocumentNumber($documentNumber)
    {
        $this->documentNumber = $documentNumber;
    
        return $this;
    }

    /**
     * Get documentNumber
     *
     * @return string 
     */
    public function getDocumentNumber()
    {
        return $this->documentNumber;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Member
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
     * Set lastname
     *
     * @param string $lastname
     * @return Member
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    
        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return Member
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;
    
        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Member
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Member
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Member
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set celularPhone
     *
     * @param string $celularPhone
     * @return Member
     */
    public function setCelularPhone($celularPhone)
    {
        $this->celularPhone = $celularPhone;
    
        return $this;
    }

    /**
     * Get celularPhone
     *
     * @return string 
     */
    public function getCelularPhone()
    {
        return $this->celularPhone;
    }
    /**
     * @var boolean
     */
    private $isActive;


    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Member
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