<?php

namespace App\Controller;

use App\Entity\QueryFilter;
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
	/**
	 * @Route("/default", name="default")
	 */
	public function index(Request $request, LoggerInterface $logger)
	{
		$queryFilter = new QueryFilter();
		$form = $this->createFormBuilder($queryFilter)
			->add('companySymbol', TextType::class)
			->add('startDate', DateType::class)
			->add('endDate', DateType::class)
			->add('email', EmailType::class)
			->add('save', SubmitType::class, ['label' => 'Create Task'])
			->getForm();


		$clientSideValidation = $request->get('clientSideValidation');
		$logger->info($clientSideValidation);
		$viewParams = [
			'form' => $form->createView(),
			'clientSideValidation' => $clientSideValidation
		];
		return $this->render('default/index.html.twig', $viewParams);
	}
}
