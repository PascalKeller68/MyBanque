<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\CreateAccountType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAccountController extends AbstractController
{
    #[Route('/creercompte', name: 'createaccount')]
    public function registration(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();
        $formRegistration = $this->createForm(CreateAccountType::class, $user);

        $formRegistration->handleRequest($request);
        $user->setRole(1);
        $user->setValidation(false);

        if ($formRegistration->isSubmitted() && $formRegistration->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login');
        }

        return $this->render(
            'create_account\registration.html.twig',
            ['form' => $formRegistration->createView()]
        );
    }

    #[Route('/connexion', name: 'login')]
    public function login()
    {
        return $this->render('create_account\login.html.twig');
    }
}
