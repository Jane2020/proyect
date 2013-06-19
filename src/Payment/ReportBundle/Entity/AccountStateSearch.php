<?php
namespace Payment\ReportBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class AccountStateSearch {
	/**
	 * @var int $account
	 */
	private $account;

	/**
	 * @var int $yearAccount
	 */

	private $yearAccount;

	/**
	 * Get account
	 *
	 * @return int
	 */
	public function getAccount() {
		return $this->account;
	}

	/**
	 * Set account
	 *
	 * @param int $account
	 */
	public function setAccount($account) {
		$this->account = $account;
	}

	/**
	 * Set yearAccount
	 *
	 * @param int $yearAccount
	 */
	public function setYearAccount($yearAccount) {
		$this->yearAccount = $yearAccount;
	}

	/**
	 * Get yearAccount
	 *
	 * @return int
	 */
	public function getYearAccount() {
		return $this->yearAccount;
	}

}
