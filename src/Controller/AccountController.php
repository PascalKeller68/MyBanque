<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\User;
use App\Repository\BankRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/compte', name: 'listeCompte')]
    public function AffichageCompte(): Response
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser()->getId());

        $bank = $this->getDoctrine()->getRepository(Bank::class)->findBy(['connectAccount' => $user]);


        //dd($bank);


        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'validation_user' => $user->getValidation(),
            'banks' => $bank
        ]);
    }
}
