<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class QueryFilter
{
	/**
	 * @Assert\NotBlank()
	 */
	protected $_companySymbol;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Type("\DateTime")
	 */
	protected $_startDate;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Type("\DateTime")
	 */
	protected $_endDate;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Email(message = "The email '{{ value }}' is not a valid email.", checkMX = true)
	 */
	protected $_email;

	public function getCompanySymbol()
	{
		return $this->_companySymbol;
	}

	public function setCompanySymbol($companySymbol)
	{
		$this->_companySymbol = $companySymbol;
	}

	public function getStartDate()
	{
		return $this->_startDate;
	}

	public function setStartDate($startDate)
	{
		$this->_startDate = $startDate;
	}

	public function getEndDate()
	{
		return $this->_endDate;
	}

	public function setEndDate($endDate)
	{
		$this->_endDate = $endDate;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function setEmail($email)
	{
		$this->_email = $email;
	}
}