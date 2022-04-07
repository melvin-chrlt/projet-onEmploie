<?php

namespace App\Controller;

use App\Repository\CVRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil', name:'app_profil')]
    #[IsGranted('ROLE_CANDIDATE')]
    // #[Route('/profil/{id<d+>}', name:'app_profil')]
    public function monCV(CVRepository $entityRepository): Response
    {
        $entities = $entityRepository->findAll();
        
        return $this->render('profil/index.html.twig', [
            'entities' => $entities,
        ]);
    }
}
