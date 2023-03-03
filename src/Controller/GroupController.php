<?php

namespace App\Controller;

use App\Entity\Group;
use App\Entity\UserGroup;
use App\Form\GroupType;
use App\Repository\GroupRepository;
use App\Repository\UserGroupRepository;
use App\Repository\UserRepository;
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
        for ($i = 0; $i <= count($userGroupes) - 1; $i++) {
            if ($i == 0) {
                $tableau[] = [
                    'numGroup' => $userGroupes[$i]['numGroup'],
                    'nameGroup' => $userGroupes[$i]['nameGroup'],
                    'accesGroup' => $userGroupes[$i]['accesGroup'],
                    'descriptionGroup' => $userGroupes[$i]['descriptionGroup'],
                    'id' => $userGroupes[$i]['id'],
                    'users' => [
                        0 => [
                            'role' => $userGroupes[$i]['role'],
                            'username' => $userGroupes[$i]['username']
                        ]
                    ]
                ];
            } elseif ($userGroupes[$i - 1]['numGroup'] != $userGroupes[$i]['numGroup']) {
                $tableau[] = [
                    'numGroup' => $userGroupes[$i]['numGroup'],
                    'nameGroup' => $userGroupes[$i]['nameGroup'],
                    'accesGroup' => $userGroupes[$i]['accesGroup'],
                    'descriptionGroup' => $userGroupes[$i]['descriptionGroup'],
                    'id' => $userGroupes[$i]['id'],
                    'users' => [
                        0 => [
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
    public function ajaxAddGroup(Request $request, UserGroupRepository $userGroupRepository, GroupRepository $groupRepository): JsonResponse
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
            $group->setNumGroup('GROUP1');
        }
        $groupRepository->save($group, true);
        $userGroup = new UserGroup;
        $userGroup->addIdGroup($group)
            ->addIdUser($user)
            ->setRole('Createur');
        $userGroupRepository->save($userGroup, true);
        $data = ['nameGroup' => $nameGroup, 'username' => $user->getUsername(), 'role' => 'Createur', 'id' => $lastGroup[0]->getId() + 1];

        return new JsonResponse($data);
    }
    #[Route('/group/user/disband', name: 'app_delete_group')]
    public function ajaxDeleteGroup(Request $request, GroupRepository $groupRepository, UserGroupRepository $userGroupRepository): Response
    {
        $idGroup = $request->query->getInt('id');

        $group = $groupRepository->findOneBy(["id" => $idGroup]);

        $idUsersGroup = $groupRepository->findIdUsersGroup($idGroup);
        foreach ($idUsersGroup as $idUserGroup) {
            $userInGroup = $userGroupRepository->findOneBy(['id' => $idUserGroup]);
            $userGroupRepository->remove($userInGroup, true);
        }
        $groupRepository->remove($group, true);

        return $this->redirectToRoute('app_group');
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
    public function ajaxAddUserToGroup(Request $request, UserGroupRepository $userGroupRepository, GroupRepository $groupRepository): Response
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

        return new Response($user->getUsername());
    }
    #[Route('/group/user/delete/invite', name: 'app_delete_detail_group')]
    public function ajaxDeleteUserToGroup(Request $request, UserGroupRepository $userGroupRepository, GroupRepository $groupRepository, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);

        if (isset($data['id'])) {
            $idGroup = $data['id'];
            $idUserGroup = $groupRepository->findIdUserGroup($user->getId(), $idGroup);
            $userInGroup = $userGroupRepository->findOneBy(['id' => $idUserGroup]);
        } else {
            $idGroup = $data['idGroup'];
            $username = $data['username'];

            $user = $userRepository->findOneBy(['username' => $username]);
            $idUserGroup = $groupRepository->findIdUserGroup($user->getId(), $idGroup);
            $userInGroup = $userGroupRepository->findOneBy(['id' => $idUserGroup]);
        }

        $userGroupRepository->remove($userInGroup, true);

        return new Response('Suppression bien effectué');
    }
    #[Route('/group/user/confirm/add', name: 'app_confirm_add_group')]
    public function ajaxConfirmAddGroup(Request $request, UserRepository $userRepository, GroupRepository $groupRepository, UserGroupRepository $userGroupRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $idGroup = $data['idGroup'];
        $username = $data['username'];

        $user = $userRepository->findOneBy(['username' => $username]);
        $idUserGroup = $groupRepository->findIdUserGroup($user->getId(), $idGroup);
        $userInGroup = $userGroupRepository->findOneBy(['id' => $idUserGroup]);

        $userInGroup->setRole('Membre');

        $userGroupRepository->save($userInGroup, true);

        return new Response('Membre confirmé');
    }
}
