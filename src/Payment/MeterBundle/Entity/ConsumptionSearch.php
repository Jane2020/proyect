<?php
namespace Payment\MeterBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class ConsumptionSearch {

	private $account;

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

	public function getAccount() {
		return $this->account;
	}

	public function setAccount($account) {
		$this->account = $account;
	}

}
