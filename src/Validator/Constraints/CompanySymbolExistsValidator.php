<?php

namespace App\Validator\Constraints;

use App\Entity\Company;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CompanySymbolExistsValidator extends ConstraintValidator
{
	public function validate($symbol, Constraint $constraint)
	{
		$companySymbolExists = $this->_companySymbolExists($symbol);
		if (!$companySymbolExists) {
			$this->context->buildViolation($constraint->message)
				->setParameter('{{ string }}', $symbol)
				->addViolation();
		}
	}

	protected function _companySymbolExists($symbol)
	{
		$companies = Company::getCompanies();
		foreach ($companies as $company) {
			if (strtoupper(trim($symbol)) == $company->getSymbol()) {
				return true;
			}
		}
		return false;
	}
}