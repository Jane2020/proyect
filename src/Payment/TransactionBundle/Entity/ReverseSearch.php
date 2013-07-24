<?php
namespace Payment\TransactionBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class ReverseSearch {

	/**
	 * @Assert\Regex(
     *     pattern = "/^[0-9]+$/",
     *     message = "Por favor ingrese correctamente el Número de Factura." )
	 * @var unknown
	 */
	private $number;

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

	public function getNumber() {
		return $this->number;
	}

	public function setNumber($number) {
		$this->number = $number;
	}

}
