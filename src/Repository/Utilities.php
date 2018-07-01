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

	static function csvStringToHtmlTable($source)
	{
		$html = "<table>\n\n";
		$lines = explode("\n", $source);

		foreach ($lines as $line) {
			$html .= "<tr>";
			$cells = explode(",", $line);
			foreach ($cells as $cell) {
				$html .= "<td>" . htmlspecialchars($cell) . "</td>";
			}
			$html .= "</tr>\n";
		}
		$html .= "\n</table>";
		return $html;
	}
}
