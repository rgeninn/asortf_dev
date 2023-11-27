<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractController
{

    #[Route('/vue_generale', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/licencies', name: 'app_licencees')]
    public function licensees(EntityManagerInterface $manager): Response
    {
        $users = [];
        $usersRepository = $manager->getRepository(User::class);
        if($usersRepository !== null) {
           $users = $usersRepository->findAll();
        }

        return $this->render('dashboard/licensees.html.twig', [
            'users' => $users
        ]);
    }

    #[Route(
        '/licencies/{id}',
        name: 'profil')
    ]
    public function profile(EntityManagerInterface $manager, UserInterface $logged, $id): Response
    {
        dump($logged->hasRole('ROLE_EDIT'));
        $user = null;
        $canEdit = '';
        $usersRepository = $manager->getRepository(User::class);
        if($usersRepository !== null) {
            $user = $usersRepository->findOneById(['id'=> $id]);
        }
        if($user === null) {
            //            DISPLAY 404
        } else {
            if ($user->getId()  === $logged->getId()) {
                $canEdit = "C'est mon profil";
//    SAME USER CAN EDIT
            } else if($logged->hasRole('ROLE_EDIT')){
//    SAME USER CAN VIEW PROFILE
                $canEdit = "C'est pas mon profil mais je peux le gérer";

            }
        }



        return $this->render('dashboard/profile.html.twig', [
            'user' => $user,
            'info' => $canEdit,
        ]);
    }

    #[Route('/calendrier', name: 'app_calendrier')]
    public function calendar(): Response
    {
        return $this->render('dashboard/calendar/view.html.twig', [
        ]);
    }
}
