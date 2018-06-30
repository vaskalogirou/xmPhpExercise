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
	private $logger;

	public function __construct(LoggerInterface $logger)
	{
		$this->logger = $logger;
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
			$this->_sendMail($queryFilter);
//			return $this->redirectToRoute('test');
		}

		$viewParams = [
			'form' => $form->createView(),
			'clientSideValidation' => $request->get('clientSideValidation')
		];
		return $this->render('default/index.html.twig', $viewParams);
	}

	private function _getQueryFilterForm()
	{
		$queryFilter = new QueryFilter();
		$form = $this->createFormBuilder($queryFilter)
			->add('companySymbol', TextType::class)
			->add('startDate', DateType::class)
			->add('endDate', DateType::class)
			->add('email', EmailType::class)
			->add('save', SubmitType::class, ['label' => 'Create Task'])
			->getForm();
		return $form;
	}

	private function _sendMail($queryFilter)
	{
		$name = $this->_getCompanyNameByFilter($queryFilter);
		$email = trim($queryFilter->getEmail());
		$body = $this->_getMailBody($queryFilter);


		$message = (new \Swift_Message())
			->setSubject($name)
			->setFrom('vaskalogirou@gmail.com')
			->setTo($email)
			->setBody($body);
//		$this->get('mailer')->send($message);
	}

	private function _getCompanyNameByFilter($queryFilter)
	{
		$symbol = $queryFilter->getName();
		$company = Company::getCompanyBySymbol($symbol);
		$name = $company->getName();
		return $name;
	}

	private function _getMailBody($queryFilter)
	{
		$result = 'From ';
		$result .= $queryFilter->getStartDate();
		$result .= ' to ';
		$result .= $queryFilter->getEndDate();
		return $result;
	}
}
