<?php
namespace Payment\TransactionBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class ExpenseSearch {

	private $expenseDate;
	private $expenseName;
	private $expenseRuc;

	/**
	 * @var int $offset
	 */
	private $offset;

	/**
	 * @var int $limit
	 */
	private $limit;

	/**
	 * Set offset
	 *
	 * @param int $offset
	 */
	public function setOffset($offset) {
		$this->offset = $offset;
	}

	/**
	 * Get offset
	 *
	 * @return int
	 */
	public function getOffset() {
		return $this->offset;
	}
	/**
	 * Set limit
	 *
	 * @param int $limit
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}

	/**
	 * Get limit
	 *
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}

	public function getExpenseDate() {
		return $this->expenseDate;
	}

	public function setExpenseDate($expenseDate) {
		$this->expenseDate = $expenseDate;
	}

	public function getExpenseName() {
		return $this->expenseName;
	}

	public function setExpenseName($expenseName) {
		$this->expenseName = $expenseName;
	}

	public function getExpenseRuc() {
		return $this->expenseRuc;
	}

	public function setExpenseRuc($expenseRuc) {
		$this->expenseRuc = $expenseRuc;
	}

}
