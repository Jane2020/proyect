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
	* @Assert\NotBlank(
	*   message = "Por favor ingrese el mes de inicio."
	*   )
	*/
	private $mounthStart;

	/**
	 * @Assert\NotBlank(
	 *   message = "Por favor ingrese el mes de fin."
	 *   )
	 */
	private $mounthEnd;

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

	public function getMounthStart() {
		return $this->mounthStart;
	}

	public function setMounthStart($mounthStart) {
		$this->mounthStart = $mounthStart;
	}

	public function getMounthEnd() {
		return $this->mounthEnd;
	}

	public function setMounthEnd($mounthEnd) {
		$this->mounthEnd = $mounthEnd;
	}

}
