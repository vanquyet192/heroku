<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    #[Route('/ordersuccess', name: 'app_order_success')]
    public function index(): Response
    {
        return $this->render('order_success/index.html.twig', [
            'controller_name' => 'OrderSuccessController',
        ]);
    }
}
