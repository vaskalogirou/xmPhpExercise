<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as CustomAssert;

class QueryFilter
{
	/**
	 * @Assert\NotBlank()
	 * @CustomAssert\CompanySymbolExists
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
	 * @Assert\Expression("value >= this.getStartDate()", message="The start date should be earlier than the end date!")
	 */
	protected $_endDate;

	/**
	 * @Assert\NotBlank()
	 * @Assert\Email(message = "The email '{{ value }}' is not a valid email.", checkMX = true)
	 */
	protected $_email;

	const BASE_URL = 'https://www.quandl.com/api/v3/datasets/WIKI/';

	function getCompanySymbol()
	{
		return $this->_companySymbol;
	}

	function setCompanySymbol($companySymbol)
	{
		$this->_companySymbol = strtoupper(trim($companySymbol));
	}

	function getStartDate()
	{
		return $this->_startDate;
	}

	function setStartDate($startDate)
	{
		$this->_startDate = $startDate;
	}

	function getEndDate()
	{
		return $this->_endDate;
	}

	function setEndDate($endDate)
	{
		$this->_endDate = $endDate;
	}

	function getEmail()
	{
		return $this->_email;
	}

	function setEmail($email)
	{
		$this->_email = $email;
	}

	function buildUrl()
	{
		$startDate = $this->_startDate->format('Y-m-d');
		$endDate = $this->_endDate->format('Y-m-d');
		$data = [
			'order' => 'asc',
			'start_date' => $startDate,
			'end_date' => $endDate
		];
		$queryString = http_build_query($data);
		$uri = self::BASE_URL . $this->_companySymbol . '.csv?' . $queryString;
		return $uri;
	}
}