<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CompanySymbolExists extends Constraint
{
	public $message = 'We could not find a company with the symbol" "{{ string }}"';
}