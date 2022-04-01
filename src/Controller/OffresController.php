<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Form\OffresType;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OffresController extends AbstractController
{
     
    // -- ADD OFFER --
    #[Route('/offres', name: 'app_offres')]
    public function newOffres(Request $request, EntityManagerInterface $em): Response
    {
        $offres = new Offres();
        $offres->setAuthor($this->getUser());
        $form = $this->createForm(OffresType::class, $offres);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offres);
            $em->flush();

            return $this->redirectToRoute('app_mes_offres');
        }
        
        return $this->render('offres/index.html.twig', [
            'formNewOffres' => $form->createView()
        ]);
        
        // return $this->render('mes_offres/index.html.twig', [
        //     'formNewOffres' => $form->createView()
        // ]);
    }

    // -- SHOW ALL OFFERS --
    #[Route('/mesOffres', name:'app_mes_offres')]
    public function mesOffres(OffresRepository $entityRepository): Response
    {
        $entities = $entityRepository->findAll();
        
        return $this->render('mes_offres/index.html.twig', [
            'entities' => $entities,
        ]);
    }
    
    // -- SHOW AN OFFER --
    #[Route('/entity/{id<\d+>}', name:'app_mon_offre')]
    public function show(Offres $entity)
    {
        return $this->render('mon_offre/index.html.twig', [
            'entity' => $entity,
        ]);
    }

    
    // #[Route('/mesOffres', name:'app_mes_offres')]
    // public function User(UserRepository $entityRepository): Response
    // {
        //     $userEntities = $entityRepository->findAll();
        
        //     return $this->render('mes_offres/index.html.twig', [
            //         'userEntities' => $userEntities,
            //     ]);
            // }
    
    // -- EDIT OFFER --     
    #[Route('/edit/{id<\d+>}', name:'app_edit_offre')]
    public function edit(EntityManagerInterface $em, Request $request, Offres $entity)
    {
        $form = $this->createForm(OffresType::class, $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offre = $this->getUser();
            $entity->setAuthor($offre);

            $em->flush();

            $this->addFlash('success', 'Votre offre a bien été modifiée.');

            return $this->redirectToRoute('app_mes_offres');
        }
        
        return $this->renderForm('edit_offre/index.html.twig', [
            'entity' => $entity,
            'form' => $form,
        ]);
    }

    // -- DELETE OFFER --
    #[Route('/delete/{id<\d+>}', name:'app_delete_offre')]
    public function delete(Request $request, Offres $entity, EntityManagerInterface $em)
    {
        if ($this->isCsrfTokenValid('entity_delete_'.$entity->getId(), $request->request->get('csrf_token'))) {
                $em->remove($entity);
                $em->flush();
        }
    
        return $this->redirectToRoute('app_mes_offres');
    }
}
