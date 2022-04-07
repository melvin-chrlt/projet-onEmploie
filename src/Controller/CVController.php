<?php

namespace App\Controller;

use App\Entity\CV;
use App\Form\CVType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CVController extends AbstractController
{
    #[Route('/cv', name:'app_cv')]
    #[IsGranted('ROLE_CANDIDATE')]
    public function addCV(EntityManagerInterface $em, Request $request): Response
    {
        $cv = new CV();
        $cv->setAuthor($this->getUser());
        $form = $this->createForm(CVType::class, $cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($cv);
            $em->flush();

            $this->addFlash('success', 'Votre CV a bien été créé.');

            return $this->redirectToRoute('app_profil');
        }
        
        return $this->render('cv/index.html.twig', [
            'formNewCV' => $form->createView()
        ]);
    }

    #[Route('/edit/{id<\d+>}', name:'app_edit_cv')]
    #[IsGranted('ROLE_CANDIDATE')]
    public function edit(EntityManagerInterface $em, Request $request, CV $entity)
    {
        if($this->getUser() === $entity->getAuthor()){

            $form = $this->createForm(CVType::class, $entity);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $cv = $this->getUser();
                $entity->setAuthor($cv);

                $em->flush();

                $this->addFlash('success', 'Votre CV a bien été modifié.');

                return $this->redirectToRoute('app_profil');
            }
            
            return $this->renderForm('edit_cv/index.html.twig', [
                'entity' => $entity,
                'form' => $form,
            ]);
        } 
        // else {
        //     $this->addFlash('error', 'Vous ne pouvez pas modifier ni supprimer une offre qui ne vous appartient pas.');
        //     return $this->redirectToRoute('app_mes_offres');
        // }
    }
}
