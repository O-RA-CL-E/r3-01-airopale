<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/villes')]
class VilleController extends AbstractController
{
    #[Route('', name: 'ville_liste', methods: ['GET'])]
    public function liste(VilleRepository $villeRepository): Response
    {
        return $this->render('ville/liste.html.twig', [
            'villes' => $villeRepository->findBy([], ['nom' => 'ASC']),
        ]);
    }
}