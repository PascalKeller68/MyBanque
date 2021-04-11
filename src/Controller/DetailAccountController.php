<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\Transaction;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailAccountController extends AbstractController
{
    #[Route('/detailaccount/{id}', name: 'detailAccount')]
    public function index($id): Response
    {
        $bank = $this->getDoctrine()
            ->getRepository(Bank::class)
            ->find($id);

        $tabletransation = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAll($bank);


        return $this->render('detail_account/index.html.twig', [
            'controller_name' => 'DetailAccountController',
            'tablesTransaction' => $tabletransation
        ]);
    }

    #[Route('/virement', name: 'virement')]
    public function virement()
    {
        $bank = $this->getDoctrine()
            ->getRepository(Bank::class)
            ->findAll();

        $tabletransation = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAll($bank);

        return $this->render('detail_account/virement.html.twig', [
            'controller_name' => 'DetailAccountController',
            'banks' => $bank
        ]);
    }

    // #[Route('/depot', name: 'depot')]
    // public function depot(ManagerRegistry $manager)
    // {

    //     $manager = $this->getDoctrine()->getManager();

    //     $bank = $this->getDoctrine()
    //         ->getRepository(Bank::class)
    //         ->findAll();

    //     // $tabletransation = $this->getDoctrine()
    //     //     ->getRepository(Transaction::class)
    //     //     ->findAll($bank);

    //     return $this->render('detail_account/depot.html.twig', [
    //         'controller_name' => 'DetailAccountController',
    //         'banks' => $bank
    //     ]);

    //     // if ($bank) {
    //     //     $manager->persist($tabletransation);
    //     //     $manager->flush();
    //     //     return $this->redirectToRoute('listeCompte');
    //     // }
    // }



}
