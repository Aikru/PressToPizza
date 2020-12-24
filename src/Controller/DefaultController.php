<?php

namespace App\Controller;

use App\Entity\Pizza;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $repository =  $this->getDoctrine()
        ->getRepository(Pizza::class);

        $pizzas = $repository->findAll();
        
        return $this->render('default/index.html.twig', [
            'pizzas' => $pizzas,
        ]);
    }

}