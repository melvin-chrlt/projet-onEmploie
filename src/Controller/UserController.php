<?php

namespace App\Controller;

use App\Repository\OffresRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
#[IsGranted('ROLE_USER')]
class UserController extends AbstractController
{
    #[Route('/offers', name: 'app_user')]
    public function index(OffresRepository $offreRepository): Response
    {
        $user = $this->getUser();
        $offers = $offreRepository->findBy(['author' => $user->getUserId()], ['createdAt' => 'DESC']);
        
        return $this->render('user/offers.html.twig', [
            'offers' => $offers,
        ]);
    }
}
