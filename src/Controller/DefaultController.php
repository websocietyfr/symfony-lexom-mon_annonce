<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/default', name: 'default_')]
class DefaultController extends AbstractController {

    #[Route('/homepage', name: 'home')]
    public function index(): Response {
        return $this->render('home.html.twig', [
            'text' => 'hello world'
        ]);
    }
    
    #[Route('/contact', name: 'contact')]
    public function contact(): Response {
        return new Response('hello');
    }
}