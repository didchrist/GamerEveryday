<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\UserGroup;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\UserGroupRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_USER')]
class GroupController extends AbstractController
{
    #[Route('/group', name: 'app_group')]
    public function index(GroupRepository $groupRepository): Response
    {
        $user = $this->getUser();

        $groupes = $groupRepository->findGroupById($user);
        $tableau = [];
        for ($i = 0; $i <= count($groupes)-1; $i++) {
            if ($i == 0) {
                $tableau[] = ['numGroup' => $groupes[$i]['numGroup'], 
                'nameGroup' => $groupes[$i]['nameGroup'], 
                'accesGroup' => $groupes[$i]['accesGroup'], 
                'descriptionGroup' => $groupes[$i]['descriptionGroup'],
                'id' => $groupes[$i]['id'],
                'users' => [ 0 => [
                        'role' => $groupes[$i]['role'],
                        'username' => $groupes[$i]['username']
                        ]
                    ]
                ];
            } elseif ($groupes[$i-1]['numGroup'] != $groupes[$i]['numGroup']) {
                $tableau[] = ['numGroup' => $groupes[$i]['numGroup'], 
                'nameGroup' => $groupes[$i]['nameGroup'], 
                'accesGroup' => $groupes[$i]['accesGroup'], 
                'descriptionGroup' => $groupes[$i]['descriptionGroup'],
                'id' => $groupes[$i]['id'],
                'users' => [ 0 => [
                        'role' => $groupes[$i]['role'],
                        'username' => $groupes[$i]['username']
                        ]
                    ]
                ];
            } else {
                $key = array_key_last($tableau);
                $tableau[$key]['users'][] =  [
                    'role' => $groupes[$i]['role'],
                    'username' => $groupes[$i]['username']
                ];
            }
        }
        $groupes = $tableau;
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        
        return $this->render('group/index.html.twig', [
            'groupes' => $groupes,
            'groupForm' => $form->createView(),
        ]);
    }
    #[Route('/group/user/add', name: 'app_add_group')]
    public function ajaxAddGroup(Request $request,UserGroupRepository $userGroupRepository, GroupRepository $groupRepository):JsonResponse
    {
        $user = $this->getUser();

        $group = $request->get('group');
        $nameGroup = $group['nameGroup'];
        $accesGroup = $group['accesGroup'];
        $descriptionGroup = $group['descriptionGroup'];

        $group = new Group();
        $group->setNameGroup($nameGroup)
            ->setAccesGroup($accesGroup)
            ->setDescriptionGroup($descriptionGroup);
        $lastGroup = $groupRepository->findBy([], ['id' => 'DESC'], 1);
        if ($lastGroup) {
            $numGroup  = 'GROUP' . ($lastGroup[0]->getId() + 1);
            $group->setNumGroup($numGroup);
        } else {
            $group->setNumGroup('GROUP00001');
        }
        $groupRepository->save($group, true);
        $userGroup = new UserGroup;
        $userGroup->addIdGroup($group)
            ->addIdUser($user)
            ->setRole('Createur');
        $userGroupRepository->save($userGroup, true);
        $data = ['nameGroup' => $nameGroup, 'username' => $user->getUsername(), 'role' => 'Createur', 'id' => $lastGroup[0]->getId()+1];

        return new JsonResponse($data);
    }
    
    #[Route('/group/user/{id}', name: 'app_detail_group')]
    public function detailGroup($id) 
    {

        return $this->render('group/group.html.twig');
    }
}
