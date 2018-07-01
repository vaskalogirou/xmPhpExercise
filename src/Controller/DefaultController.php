<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\QueryFilter;
use App\Repository\Utilities;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class DefaultController extends Controller
{
	private $_logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->_logger = $logger;
	}

	/**
	 * @Route("/default", name="default")
	 */
	public function index(Request $request)
	{
		$form = $this->_getQueryFilterForm();
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$queryFilter = $form->getData();
			$url = $queryFilter->buildUrl();
			$this->_logger->info($url);
//			$source = file_get_contents($url);
//			$htmlTable = Utilities::csvStringToHtmlTable($source);
//			$message = $queryFilter->composeMessage();
//			$this->get('mailer')->send($message);
//			return $this->render('default/display.html.twig', ['table' => $htmlTable]);
		}

		$viewParams = [
			'form' => $form->createView(),
			'clientSideValidation' => $request->get('clientSideValidation')
		];
		return $this->render('default/index.html.twig', $viewParams);
	}

	/**
	 * @Route("/test", name="test")
	 */
	public function test()
	{
		$symbol = 'DDD';
		$company = Company::getCompanyBySymbol($symbol, $this->_logger);
		$name = $company->getName();
		$this->_logger->info($name);
	}

	private function _getQueryFilterForm()
	{
		$queryFilter = new QueryFilter();
		$form = $this->createFormBuilder($queryFilter)
			->add('companySymbol', TextType::class)
			->add('startDate', TextType::class)
			->add('endDate', TextType::class)
			->add('email', EmailType::class)
			->add('save', SubmitType::class, ['label' => 'Create Task'])
			->getForm();
		return $form;
	}
}
