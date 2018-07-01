<?php

namespace App\Repository;


use App\Entity\Company;

class Utilities
{
	static function getCompaniesFromCsv($path)
	{
		$companies = [];
		if (($pointer = fopen($path, "r")) !== FALSE) {
			while (($row = fgetcsv($pointer, 1000, ",")) !== FALSE) {
				$companies[] = new Company($row);
			}
			fclose($pointer);
		}
		return $companies;
	}
}
