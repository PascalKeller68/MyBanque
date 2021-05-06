<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\User;
use App\Entity\Beneficiary;
use App\Entity\DeleteUser;
use App\Entity\Transaction;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

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

        $delUsers = $this->getDoctrine()
            ->getRepository(DeleteUser::class)
            ->findAll();

        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'users' => $users,
            'beneficiarys' => $beneficiarys,
            'delUsers' => $delUsers
        ]);
    }

    #[Route('/admin', name: 'adminDashboard')]
    public function adminDashboard(): Response
    {

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $beneficiarys = $this->getDoctrine()
            ->getRepository(Beneficiary::class)
            ->findAll();

        $delUsers = $this->getDoctrine()
            ->getRepository(DeleteUser::class)
            ->findAll();

        return $this->render('dashboard/adminDashboard.html.twig', [
            'controller_name' => 'DashboardController',
            'users' => $users,
            'beneficiarys' => $beneficiarys,
            'delUsers' => $delUsers
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

    #[Route('/admin/removeAdmin/{id}', name: 'suppressionAdmin')]
    public function suppressionAdmin($id, ManagerRegistry $manager)
    {
        $manager = $this->getDoctrine()->getManager();       

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('adminDashboard');
    }

    #[Route('/dashboard/addBene/{id}', name: 'validationBeneficiaire')]
    public function validationBeneficiary($id, ManagerRegistry $manager)
    {

        $beneficiary = $this->getDoctrine()
            ->getRepository(Beneficiary::class)
            ->find($id);

        $beneficiary->setValidation(1);


        $manager = $this->getDoctrine()->getManager();
        $manager->persist($beneficiary);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    }

    #[Route('/dashboard/removeBene/{id}', name: 'suppressionBeneficiaire')]
    public function suppressionBeneficiary($id, ManagerRegistry $manager)
    {
        $manager = $this->getDoctrine()->getManager();

        $beneficiary = $this->getDoctrine()
            ->getRepository(Beneficiary::class)
            ->find($id);

        $manager->remove($beneficiary);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    }


    #[Route('/dashboard/DeleteUser/{id}', name: 'deleteUser')]
    public function deleteUser($id, ManagerRegistry $manager)
    {
        $manager = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        $banks = $this->getDoctrine()->getRepository(Bank::class)->findBy(['connectAccount' => $user]);

        foreach ($banks as $bank) {
            $transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy(['connectBank' => $bank]);

            foreach ($transactions as $transaction) {
                # code...
                $bank->removeTransaction($transaction);
                $manager->remove($transaction);
            }

            $user->removeBank($bank);
            $manager->remove($bank);
        }

        $beneficiarys = $this->getDoctrine()->getRepository(Beneficiary::class)->findBy(['connectUser' => $user]);
        foreach ($beneficiarys as $beneficiary) {
            # code...
            $user->removeBeneficiary($beneficiary);
            $manager->remove($beneficiary);
        }

        $deleteRequest = $this->getDoctrine()->getRepository(DeleteUser::class)->findOneBy(['connectUserDel' => $user]);

        //delete file
        $filesystem = new Filesystem();
        $path = 'uploads/deleteRequest/' . $deleteRequest->getDocumentSuppression();
        $filesystem->remove($path);

        $manager->remove($deleteRequest);
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    }

    #[Route('/dashboard/cancelDeleteUser/{id}', name: 'cancelDeleteUser')]
    public function cancelDeleteUser($id, ManagerRegistry $manager)
    {
        $manager = $this->getDoctrine()->getManager();


        $deleteRequest = $this->getDoctrine()
            ->getRepository(DeleteUser::class)
            ->find($id);

        //delete file
        $filesystem = new Filesystem();
        $path = 'uploads/deleteRequest/' . $deleteRequest->getDocumentSuppression();
        $filesystem->remove($path);

        $manager->remove($deleteRequest);
        $manager->flush();
        return $this->redirectToRoute('dashboard');
    }
}
