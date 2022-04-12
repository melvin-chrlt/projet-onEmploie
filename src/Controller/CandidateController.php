<?php

namespace App\Controller;

use App\Form\CandidateType;
use App\Repository\OffresRepository;
use App\Repository\CandidateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/candidate')]
class CandidateController extends AbstractController
{
    #[Route('/', name: 'app_candidate_profile')]
    #[IsGranted('ROLE_CANDIDATE', message:"Vous devez être connecté en tant que chercheur d'emploi pour accéder à cette page.")]
    public function profile(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(CandidateType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_candidate_offers');
        }

        return $this->renderForm('candidate/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/offers', name: 'app_candidate_offers')]
    #[IsGranted('ROLE_CANDIDATE', message:"Vous devez être connecté en tant que chercheur d'emploi pour accéder à cette page.")]
    public function offers(CandidateRepository $candidateRepository, OffresRepository $offresRepository): Response
    {
        $user = $candidateRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        // $offers = $offresRepository->findBy(['contractType' => $user->getContractType()]);
        $offers = $offresRepository->findAll();
        $offersFiltered = [];
        
        foreach ($offers as $offer) {
            foreach ($offer->getCategories() as $category) {
                foreach ($user->getCategories() as $userCategory) {
                    if($category === $userCategory) {
                        $offersFiltered[] = $offer;
                    }
                }
            }
        }

        return $this->renderForm('candidate/offers.html.twig', [
            'offers' => array_unique($offersFiltered),
        ]);
    }

    #[Route('/applications', name: 'app_candidate_applications')]
    #[IsGranted('ROLE_CANDIDATE', message:"Vous devez être connecté en tant que chercheur d'emploi pour accéder à cette page.")]
    public function applications(CandidateRepository $candidateRepository): Response
    {
        $user = $candidateRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

        $offers = $user->getApplications();

        return $this->renderForm('candidate/applications.html.twig', [
            'offers' => $offers,
        ]);
    }
}
