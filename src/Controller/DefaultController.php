<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/default', name: 'default_')]
class DefaultController extends AbstractController {

    #[Route('/homepage/{id}', name: 'home')]
    public function index(int $id = 0): Response {
        return $this->render('home.html.twig', [
            'text' => 'hello world'
        ]);
    }

    #[Route('/homepage/test', name: 'test', priority: 1)]
    public function test(): Response {
        return $this->render('home.html.twig', [
            'text' => 'test'
        ]);
    }
    
    #[Route('/contact', name: 'contact')]
    public function contact(): Response {
        return new Response('hello');
    }

    #[Route('/annonces/{annonce}', name: 'annonce_show', methods: ['GET'])]
    public function showAnnonce(Annonce $annonce) {
        return $this->render('home.html.twig', [
            'text' => 'Annonce ' . $annonce->getId(),
            'annonce' => $annonce
        ]);
    }

    #[Route('/annonces/{annonce}', name:'annonce_edit', methods: ['POST', 'PUT'])]
    public function editAnnonce(Annonce $annonce, ManagerRegistry $doctrine) {
        // traitement des données du formulaire reçu en POST
        $annonce->setTitle($_POST['title']);
        $annonce->setDescription($_POST['description']);

        // persistance de l'objet modifier
        $annonceRepository = $doctrine->getRepository(Annonce::class);
        $annonceRepository->add($annonce, true);
        return $this->redirectToRoute('default_annonce_show', [
            "annonce" => $annonce->getId()
        ]);
    }
}