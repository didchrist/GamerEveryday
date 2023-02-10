<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
use App\Repository\AvailabilityGlobalRepository;
use App\Repository\AvailabilityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class AvailabilityController extends AbstractController
{
    #[Route('/availability', name: 'app_availability')]
    public function index(AvailabilityRepository $availabilityRepository, AvailabilityGlobalRepository $availabilityGlobalRepository): Response
    {
        $user = $this->getUser();
        $availabilities = $availabilityRepository->findBy(['id_user' => $user->getId()]);
        $availabilitiesGlobal = $availabilityGlobalRepository->findBy(['user_id' => $user->getId()]);

        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class, $availability);
        return $this->render('availability/index.html.twig', [
            'availabilityForm' => $form->createView(),
            'availabilities' => $availabilities,
            'availabilitiesGlobal' => $availabilitiesGlobal
        ]);
    }
}
