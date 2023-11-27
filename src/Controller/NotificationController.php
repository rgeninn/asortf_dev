<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    #[Route('/communication', name: 'app_notification')]
    public function index(): Response
    {
        return $this->render('dashboard/notification/index.html.twig', [
            'controller_name' => 'NotificationController',
        ]);
    }
}
