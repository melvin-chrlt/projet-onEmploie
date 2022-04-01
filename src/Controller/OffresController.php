<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Form\OffresType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OffresController extends AbstractController
{
            
    #[Route('/offres', name: 'app_offres')]
    public function newOffres(Request $request, EntityManagerInterface $em): Response
    {
        $offres = new Offres();
        $form = $this->createForm(OffresType::class, $offres);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offres);
            $em->flush();
        }

        return $this->render('offres/index.html.twig', [
            'formNewOffres' => $form->createView()
        ]);
    }
}
