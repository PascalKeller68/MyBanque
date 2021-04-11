<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateBeneficiaryController extends AbstractController
{
    #[Route('/create/beneficiary', name: 'create_beneficiary')]
    public function index(Request $request, ManagerRegistry $manager): Response
    {




        return $this->render('create_beneficiary/beneficiary.html.twig', [
            'controller_name' => 'CreateBeneficiaryController',
        ]);
    }
}
