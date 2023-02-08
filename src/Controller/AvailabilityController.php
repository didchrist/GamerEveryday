<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class AvailabilityController extends AbstractController
{
    #[Route('/availability', name: 'app_availability')]
    public function index(Request $request): Response
    {
        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class, $availability);
        $form->handleRequest($request);
        return $this->render('availability/index.html.twig', [
            'availabilityForm' => $form->createView()
        ]);
    }
}
