<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Entity\AvailabilityGlobal;
use App\Form\AvailabilityType;
use App\Repository\AvailabilityGlobalRepository;
use App\Repository\AvailabilityRepository;
use App\Repository\GameRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class AvailabilityController extends AbstractController
{
    #[Route('/availability', name: 'app_availability')]
    public function index(AvailabilityRepository $availabilityRepository, AvailabilityGlobalRepository $availabilityGlobalRepository): Response
    {
        $user = $this->getUser();
        $availabilities = $availabilityRepository->findBy(['id_user' => $user->getId(), 'game' => 21]);
        $availabilitiesGlobal = $availabilityGlobalRepository->findBy(['user_id' => $user->getId()]);

        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class, $availability);
        return $this->render('availability/index.html.twig', [
            'availabilityForm' => $form->createView(),
            'availabilities' => $availabilities,
            'availabilitiesGlobal' => $availabilitiesGlobal
        ]);
    }
    #[Route('/availability/listgame', name: 'app_availability_listgame')]
    public function ajaxAvailabilitiesGame (AvailabilityRepository $availabilityRepository, Request $request) : JsonResponse
    {
        $game = $request->getContent();      

        $user = $this->getUser();
        $availabilities = $availabilityRepository->findBy(['id_user' => $user->getId(), 'game' => $game]);

        foreach ($availabilities as $availability) {
            $startDate = date_format($availability->getStartDate(), "H:i d/m/Y");
            $endDate = date_format($availability->getEndDate(), "H:i d/m/Y");
            $array[] = ['startDate' => $startDate, 'endDate' => $endDate];
        }
        if (isset($array)) {
            Return new JsonResponse($array); 
        } else {
            $array = [];
            Return new JsonResponse($array);
        }
    }
    #[Route('/availability/add/global', name: 'app_add_globalAvailability')]
    public function ajaxAddGlobalAvailability (Request $request, AvailabilityGlobalRepository $availabilityGlobalRepository) : Response
    {
        $availability = new AvailabilityGlobal();
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        $startDate = new \DateTime($data['startDate'], new \DateTimeZone('Europe/Paris'));
        $startDate->setTimezone(new \DateTimeZone('UTC'));
        $endDate = new \DateTime($data['endDate'], new \DateTimeZone('Europe/Paris'));
        $endDate->setTimezone(new \DateTimeZone('UTC'));
        $availabilities = $availabilityGlobalRepository->findBy(['user_id' => $user->getId()]);
        foreach ($availabilities as $avail) {
            if ($avail->getStartDate()<= $startDate and $startDate < $avail->getEndDate()) {
                return new Response($startDate->format('H:i d/m/Y'). ' a déjà était inscrit en tant que disponibilité.');
            }
            if ($avail->getStartDate() < $endDate and $endDate <= $avail->getEndDate()) {
                return new Response($endDate->format('H:i d/m/Y'). ' a déjà était inscrit en tant que disponibilité.');
            }
        }
        $availability->setStartDate($startDate)
                    -> setEndDate($endDate)
                    ->setUserId($user);
        
        $availabilityGlobalRepository->save($availability, true);
        
        return new Response('ajout effectué');
    }
    #[Route('/availability/add', name: 'app_add_availability')]
    public function ajaxAddAvailability (Request $request, AvailabilityRepository $availabilityRepository, GameRepository $gameRepository) :Response
    {
        $availability = new Availability();
        $user = $this ->getUser();
        $data = json_decode($request->getContent(), true);

        $startDate = new \DateTime($data['startDate'], new \DateTimeZone('Europe/Paris'));
        $startDate->setTimezone(new \DateTimeZone('UTC'));
        $endDate = new \DateTime($data['endDate'], new \DateTimeZone('Europe/Paris'));
        $endDate->setTimezone(new \DateTimeZone('UTC'));
        $game = $data['game'];
        $availabilities = $availabilityRepository->findBy(['id_user' => $user->getId(),'game' => $game]);
        foreach ($availabilities as $avail) {
            if ($avail->getStartDate()>= $startDate and $startDate < $avail->getEndDate()) {
                return new Response($startDate->format('H:i d/m/Y'). ' a déjà était inscrit en tant que disponibilité.');
            }
            if ($avail->getStartDate() > $endDate and $endDate <= $avail->getEndDate()) {
                return new Response($endDate->format('H:i d/m/Y'). ' a déjà était inscrit en tant que disponibilité.');
            }
        }
        $game = $gameRepository->findOneBy(['id' => $game]);
        $availability->setStartDate($startDate)
                    ->setEndDate($endDate)
                    ->setIdUser($user)
                    ->setGame($game);

        $availabilityRepository->save($availability, true);

        return new Response('ajout effectué');
    }
}
