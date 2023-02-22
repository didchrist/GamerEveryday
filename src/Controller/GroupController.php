<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\UserGroup;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\UserGroupRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class GroupController extends AbstractController
{
    #[Route('/group', name: 'app_group')]
    public function index(UserGroupRepository $userGroupRepository, Request $request, GroupRepository $groupRepository): Response
    {
        $user = $this->getUser();

        $groupes = $userGroupRepository->findBy(['id_user' => $user->getId()]);
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        $form->handleRequest($request);
        dd($groupes);
        if ($form->isSubmitted() && $form->isValid()) {
            $lastGroup = $groupRepository->findBy([],['id' => 'DESC'], 1);
            if ($lastGroup) {
                $numGroup  = 'GROUP'. ($lastGroup[0]->getId() + 1);
                $group->setGroupNum($numGroup);
            } else {
                $group->setGroupNum('GROUP00001');
            }
            $groupRepository->save($group, true);
            $userGroup = new UserGroup;
            $userGroup->setIdGroup($group)
                    ->setIdUser($user)
                    ->setRole('Createur');
            $userGroupRepository->save($userGroup, true);

            return $this->redirectToRoute('app_group');
        }
        return $this->render('group/index.html.twig', [
            'groupes' => $groupes,
            'groupForm' => $form->createView(),
        ]);
    }
}