<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\User;
use App\Entity\Beneficiary;
use App\Repository\BankRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $beneficiarys = $this->getDoctrine()
            ->getRepository(Beneficiary::class)
            ->findAll();



        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'users' => $users,
            'beneficiarys' => $beneficiarys
        ]);
    }

    #[Route('/dashboard/add/{id}', name: 'validationUtilisateur')]
    public function validationUtilisateur($id, ManagerRegistry $manager)
    {

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $user->setValidation(1);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    }

    #[Route('/dashboard/remove/{id}', name: 'suppressionUtilisateur')]
    public function suppressionUtilisateur($id, ManagerRegistry $manager)
    {
        $manager = $this->getDoctrine()->getManager();

        $banks = $this->getDoctrine()->getRepository(Bank::class)->findBy(['connectAccount' => $id]);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);


        foreach ($banks as $bank) {

            $user->removeBank($bank);
            $manager->remove($bank);
        }


        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    }
}
