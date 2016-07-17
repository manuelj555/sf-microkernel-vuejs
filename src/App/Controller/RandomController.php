<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class RandomController extends Controller
{
	/**
	 * @Route("/random/{limit}")
	 */ 
	public function randomAction($limit) : Response
	{
		return $this->render('random/random.html.twig', ['number' => rand(1, $limit)]);
	}
}