<?php
namespace Payment\MeterBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class DateToList {
	private $mounth;
	private $year;

	public function getMounth() {
		return $this->mounth;
	}

	public function setMounth($mounth) {
		$this->mounth = $mounth;
	}

	public function getYear() {
		return $this->year;
	}

	public function setYear($year) {
		$this->year = $year;
	}

}
