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

        $groupes = $groupRepository->findAllGroupWithoutUser($user);

        $userGroupes = $groupRepository->findGroupById($user);
        $tableau = [];
        for ($i = 0; $i <= count($userGroupes)-1; $i++) {
            if ($i == 0) {
                $tableau[] = ['numGroup' => $userGroupes[$i]['numGroup'], 
                'nameGroup' => $userGroupes[$i]['nameGroup'], 
                'accesGroup' => $userGroupes[$i]['accesGroup'], 
                'descriptionGroup' => $userGroupes[$i]['descriptionGroup'],
                'id' => $userGroupes[$i]['id'],
                'users' => [ 0 => [
                        'role' => $userGroupes[$i]['role'],
                        'username' => $userGroupes[$i]['username']
                        ]
                    ]
                ];
            } elseif ($userGroupes[$i-1]['numGroup'] != $userGroupes[$i]['numGroup']) {
                $tableau[] = ['numGroup' => $userGroupes[$i]['numGroup'], 
                'nameGroup' => $userGroupes[$i]['nameGroup'], 
                'accesGroup' => $userGroupes[$i]['accesGroup'], 
                'descriptionGroup' => $userGroupes[$i]['descriptionGroup'],
                'id' => $userGroupes[$i]['id'],
                'users' => [ 0 => [
                        'role' => $userGroupes[$i]['role'],
                        'username' => $userGroupes[$i]['username']
                        ]
                    ]
                ];
            } else {
                $key = array_key_last($tableau);
                $tableau[$key]['users'][] =  [
                    'role' => $userGroupes[$i]['role'],
                    'username' => $userGroupes[$i]['username']
                ];
            }
        }
        $userGroupes = $tableau;
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);
        
        return $this->render('group/index.html.twig', [
            'userGroupes' => $userGroupes,
            'groupForm' => $form->createView(),
            'groupes' => $groupes,
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
    public function detailGroup($id, GroupRepository $groupRepository): Response
    {
        $group = $groupRepository->findOneBy(['id' => $id]);
        $user = $this->getUser();
        $userRight = $groupRepository->findUserWithGroup($user, $id); 
        return $this->render('group/group.html.twig', [
            'group' => $group,
            'userRight' => $userRight,
        ]);
    }
    #[Route('/group/user/add/invite', name: 'app_add_detail_group')]
    public function ajaxAddUserToGroup (Request $request, UserGroupRepository $userGroupRepository, GroupRepository $groupRepository) : Response
    {
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);

        $idGroup = $data['id'];
        $group = $groupRepository->findOneBy(['id' => $idGroup]);

        $userInGroup = new UserGroup();

        $userInGroup->setRole('En attente')
            ->addIdUser($user)
            ->addIdGroup($group);
        
        $userGroupRepository->save($userInGroup, true);

        return new Response('Demande ajouté');
    }
}
