<?php

namespace App\Entity;


use App\Repository\Utilities;

class Company
{
	protected $_symbol;
	protected $_name;
	protected $_lastSale;
	protected $_marketCap;
	protected $_ipoYear;
	protected $_sector;
	protected $_industry;
	protected $_summaryQuote;

	protected static $_companies;

	function __construct($params)
	{
		$this->_symbol = $params[0];
		$this->_name = $params[1];
		$this->_lastSale = $params[2];
		$this->_marketCap = $params[3];
		$this->_ipoYear = $params[4];
		$this->_sector = $params[5];
		$this->_industry = $params[6];
		$this->_summaryQuote = $params[7];
	}

	function __toString()
	{
		$delimiter = ", ";
		$result = '';
		$result .= 'Symbol: ' . $this->_symbol . $delimiter;
		$result .= 'Name: ' . $this->_name . $delimiter;
		$result .= 'LastSale: ' . $this->_lastSale . $delimiter;
		$result .= 'MarketCap: ' . $this->_marketCap . $delimiter;
		$result .= 'IPOyear: ' . $this->_ipoYear . $delimiter;
		$result .= 'Sector: ' . $this->_sector . $delimiter;
		$result .= 'industry: ' . $this->_industry . $delimiter;
		$result .= 'Summary Quote: ' . $this->_summaryQuote;
		return $result;
	}

	function getSymbol()
	{
		return $this->_symbol;
	}

	function getName()
	{
		return $this->_name;
	}

	static function getCompanies()
	{
		if (self::$_companies == null) {
//			$path = "../resources/testList.csv";
			$path = "../resources/companyList.csv";
			self::$_companies = Utilities::getCompaniesFromCsv($path);
		}

		return self::$_companies;
	}

	static function getCompanyBySymbol($symbol)
	{
		$sanitizedSymbol = strtoupper(trim($symbol));
		foreach (self::getCompanies() as $company) {
			if ($sanitizedSymbol == $company->getName()) {
				return $company;
			}
		}
		return null;
	}

}