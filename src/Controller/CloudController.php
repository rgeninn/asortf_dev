<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CloudController extends AbstractController
{
    #[Route('/fichiers', name: 'app_cloud')]
    public function index(): Response
    {
        return $this->render('dashboard/cloud/index.html.twig', [
            'controller_name' => 'CloudController',
        ]);
    }
}
