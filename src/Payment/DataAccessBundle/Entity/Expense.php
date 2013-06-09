<?php

namespace Payment\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Expense
 */
class Expense {
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var \DateTime
	 */
	private $systemDate;

	/**
	 * @var \DateTime
	 *     * @Assert\NotBlank(
	 *   message = "Por favor ingrese la Fecha de inicio."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^\d{2,4}\-\d{1,2}\-\d{1,2}$/",
	 *     message = "Valor de Fecha es incorrecto."
	 * )
	 * 
	 */
	private $expenseDate;

	/**
	 * @var float
	 * 
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el valor de la factura."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^(-)?\d+(\.\d\d)?$/",
	 *     message = "El Valor es incorrecto."
	 * )
	 */
	private $expenseValue;

	/**
	 * @var string
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
	 * @var string
	 * 
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el nombre."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/",
	 *     message = "Valor de nombre es incorrecto."
	 * )
	 * 
	 */
	private $expenseName;

	/**
	 * @var string
	 * 
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el número de factura."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^[0-9\-\.\/]+$/",
	 *     message = "Valor del número de factura es incorrecto."
	 * )
	 */
	private $expenseNumber;

	/**
	 * @var string
	 * 
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el Ruc."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^[0-9]{13}$/",
	 *     message = "Valor del ruc es incorrecto."
	 * )
	 * 
	 */
	private $expenseRuc;

	/**
	 * @var float
	 * 
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el valor del iva."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^(-)?\d+(\.\d\d)?$/",
	 *     message = "El Valor es incorrecto."
	 * )
	 *
	 */
	private $expenseIva;

	/**
	 * @var string
	 * 
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el valor de la dirección."
	 * )
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/",
	 *     message = "Valor de la direción es incorrecto."
	 * )
	 */
	private $expenseAddress;

	/**
	 * @var string
	 * 
	 * @Assert\Regex(
	 *     pattern = "/^(?:\+)?\d{9,10}$/ ",
	 *     message = "Valor del teléfono es incorrecto."
	 * )
	 * 
	 */
	private $expensePhone;

	/**
	 * @var \Payment\DataAccessBundle\Entity\Transaction
	 */
	private $transaction;

	/**
	 * Get id
	 *
	 * @return integer 
	 */
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Set systemDate
	 *
	 * @param \DateTime $systemDate
	 * @return Expense
	 */
	public function setSystemDate($systemDate) {
		$this->systemDate = $systemDate;

		return $this;
	}

	/**
	 * Get systemDate
	 *
	 * @return \DateTime 
	 */
	public function getSystemDate() {
		return $this->systemDate;
	}

	/**
	 * Set expenseDate
	 *
	 * @param \DateTime $expenseDate
	 * @return Expense
	 */
	public function setExpenseDate($expenseDate) {
		$this->expenseDate = $expenseDate;

		return $this;
	}

	/**
	 * Get expenseDate
	 *
	 * @return \DateTime 
	 */
	public function getExpenseDate() {
		return $this->expenseDate;
	}

	/**
	 * Set expenseValue
	 *
	 * @param float $expenseValue
	 * @return Expense
	 */
	public function setExpenseValue($expenseValue) {
		$this->expenseValue = $expenseValue;

		return $this;
	}

	/**
	 * Get expenseValue
	 *
	 * @return float 
	 */
	public function getExpenseValue() {
		return $this->expenseValue;
	}

	/**
	 * Set description
	 *
	 * @param string $description
	 * @return Expense
	 */
	public function setDescription($description) {
		$this->description = $description;

		return $this;
	}

	/**
	 * Get description
	 *
	 * @return string 
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Set userId
	 *
	 * @param integer $userId
	 * @return Expense
	 */
	public function setUserId($userId) {
		$this->userId = $userId;

		return $this;
	}

	/**
	 * Get userId
	 *
	 * @return integer 
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * Set isDeleted
	 *
	 * @param boolean $isDeleted
	 * @return Expense
	 */
	public function setIsDeleted($isDeleted) {
		$this->isDeleted = $isDeleted;

		return $this;
	}

	/**
	 * Get isDeleted
	 *
	 * @return boolean 
	 */
	public function getIsDeleted() {
		return $this->isDeleted;
	}

	/**
	 * Set expenseName
	 *
	 * @param string $expenseName
	 * @return Expense
	 */
	public function setExpenseName($expenseName) {
		$this->expenseName = $expenseName;

		return $this;
	}

	/**
	 * Get expenseName
	 *
	 * @return string 
	 */
	public function getExpenseName() {
		return $this->expenseName;
	}

	/**
	 * Set expenseNumber
	 *
	 * @param string $expenseNumber
	 * @return Expense
	 */
	public function setExpenseNumber($expenseNumber) {
		$this->expenseNumber = $expenseNumber;

		return $this;
	}

	/**
	 * Get expenseNumber
	 *
	 * @return string 
	 */
	public function getExpenseNumber() {
		return $this->expenseNumber;
	}

	/**
	 * Set expenseRuc
	 *
	 * @param string $expenseRuc
	 * @return Expense
	 */
	public function setExpenseRuc($expenseRuc) {
		$this->expenseRuc = $expenseRuc;

		return $this;
	}

	/**
	 * Get expenseRuc
	 *
	 * @return string 
	 */
	public function getExpenseRuc() {
		return $this->expenseRuc;
	}

	/**
	 * Set expenseIva
	 *
	 * @param float $expenseIva
	 * @return Expense
	 */
	public function setExpenseIva($expenseIva) {
		$this->expenseIva = $expenseIva;

		return $this;
	}

	/**
	 * Get expenseIva
	 *
	 * @return float 
	 */
	public function getExpenseIva() {
		return $this->expenseIva;
	}

	/**
	 * Set expenseAddress
	 *
	 * @param string $expenseAddress
	 * @return Expense
	 */
	public function setExpenseAddress($expenseAddress) {
		$this->expenseAddress = $expenseAddress;

		return $this;
	}

	/**
	 * Get expenseAddress
	 *
	 * @return string 
	 */
	public function getExpenseAddress() {
		return $this->expenseAddress;
	}

	/**
	 * Set expensePhone
	 *
	 * @param string $expensePhone
	 * @return Expense
	 */
	public function setExpensePhone($expensePhone) {
		$this->expensePhone = $expensePhone;

		return $this;
	}

	/**
	 * Get expensePhone
	 *
	 * @return string 
	 */
	public function getExpensePhone() {
		return $this->expensePhone;
	}

	/**
	 * Set transaction
	 *
	 * @param \Payment\DataAccessBundle\Entity\Transaction $transaction
	 * @return Expense
	 */
	public function setTransaction(
			\Payment\DataAccessBundle\Entity\Transaction $transaction = null) {
		$this->transaction = $transaction;

		return $this;
	}

	/**
	 * Get transaction
	 *
	 * @return \Payment\DataAccessBundle\Entity\Transaction 
	 */
	public function getTransaction() {
		return $this->transaction;
	}
	/**
	 * @var \Payment\DataAccessBundle\Entity\SystemUser
	 */
	private $changeUser;

	/**
	 * @var \Payment\DataAccessBundle\Entity\SystemUser
	 */
	private $systemUser;

	/**
	 * Set changeUser
	 *
	 * @param \Payment\DataAccessBundle\Entity\SystemUser $changeUser
	 * @return Expense
	 */
	public function setChangeUser(
			\Payment\DataAccessBundle\Entity\SystemUser $changeUser = null) {
		$this->changeUser = $changeUser;

		return $this;
	}

	/**
	 * Get changeUser
	 *
	 * @return \Payment\DataAccessBundle\Entity\SystemUser 
	 */
	public function getChangeUser() {
		return $this->changeUser;
	}

	/**
	 * Set systemUser
	 *
	 * @param \Payment\DataAccessBundle\Entity\SystemUser $systemUser
	 * @return Expense
	 */
	public function setSystemUser(
			\Payment\DataAccessBundle\Entity\SystemUser $systemUser = null) {
		$this->systemUser = $systemUser;

		return $this;
	}

	/**
	 * Get systemUser
	 *
	 * @return \Payment\DataAccessBundle\Entity\SystemUser 
	 */
	public function getSystemUser() {
		return $this->systemUser;
	}
	/**
	 * @var string
	 *
	 * @Assert\Regex(
	 *     pattern = "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\_\-\.\@\/]+$/",
	 *     message = "Valor de la descripción es incorrecto."
	 * )
	 * 
	 */
	private $expenseDescription;

	/**
	 * Set expenseDescription
	 *
	 * @param string $expenseDescription
	 * @return Expense
	 */
	public function setExpenseDescription($expenseDescription) {
		$this->expenseDescription = $expenseDescription;

		return $this;
	}

	/**
	 * Get expenseDescription
	 *
	 * @return string 
	 */
	public function getExpenseDescription() {
		return $this->expenseDescription;
	}

	public function setId($id) {
		$this->id = $id;
	}

}