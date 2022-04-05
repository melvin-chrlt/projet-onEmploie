<?php

namespace App\Controller;

use App\Entity\Offres;
use App\Form\OffresType;
use App\Repository\UserRepository;
use App\Repository\OffresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OffresController extends AbstractController
{
    // -- ADD OFFER --
    #[Route('/addOffre', name: 'app_add_offre')]
    #[IsGranted('ROLE_USER')]
    public function newOffres(Request $request, EntityManagerInterface $em): Response
    {
        $offres = new Offres(); //créer nouvelle offre
        $offres->setAuthor($this->getUser()); //récup l'auteur automatiquement
        $form = $this->createForm(OffresType::class, $offres); //créer un formulaire
        $form->handleRequest($request); //renvoi le formulaire
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($offres);
            $em->flush();

            $this->addFlash('success', 'Votre offre a bien été ajoutée.');

            return $this->redirectToRoute('app_mes_offres');
        }
        
        return $this->render('add_offres/index.html.twig', [
            'formNewOffres' => $form->createView()
        ]);
    }

    // -- SHOW ALL OFFERS --
    #[Route('/allOffres', name:'app_mes_offres')]
    public function mesOffres(OffresRepository $entityRepository): Response
    {
        $entities = $entityRepository->findBy([], ['id' => 'DESC']);
        
        return $this->render('all_offres/index.html.twig', [
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
    
    // -- EDIT OFFER --     
    #[Route('/edit/{id<\d+>}', name:'app_edit_offre')]
    #[IsGranted('ROLE_USER')]
    public function edit(EntityManagerInterface $em, Request $request, Offres $entity)
    {
        if($this->getUser() === $entity->getAuthor()){

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
        } else {
            $this->addFlash('error', 'Vous ne pouvez pas modifier ni supprimer une offre qui ne vous appartient pas.');
            return $this->redirectToRoute('app_mes_offres');
        }
    }

    // -- DELETE OFFER --
    #[Route('/delete/{id<\d+>}', name:'app_delete_offre')]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Offres $entity, EntityManagerInterface $em)
    {
        if($this->getUser() === $entity->getAuthor()){

            if ($this->isCsrfTokenValid('entity_delete_'.$entity->getId(), $request->request->get('csrf_token'))) {
                    $em->remove($entity);
                    $em->flush();
            }
            
            $this->addFlash('success', 'Votre offre a bien été supprimée.');

            return $this->redirectToRoute('app_mes_offres');

        } else {
            $this->addFlash('error', 'Vous ne pouvez pas modifier ni supprimer une offre qui ne vous appartient pas.');
            return $this->redirectToRoute('app_mes_offres');
        }
    }
}
