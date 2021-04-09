<?php

namespace App\Controller;

use App\Entity\User;
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


        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
            'validation_user' => $user->getValidation()
        ]);
    }
}
