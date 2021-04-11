<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\User;
use App\Entity\Beneficiary;
use App\Entity\Transaction;
use App\Form\FormTransationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
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
    public function virement(Request $request, ManagerRegistry $manager)
    {

        $transaction = new Transaction();
        $formTransaction = $this->createForm(FormTransationType::class, $transaction);

        $formTransaction->handleRequest($request);

        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($this->getUser()->getId());

        $bank = $this->getDoctrine()->getRepository(Bank::class)->findBy(['connectAccount' => $user]);
        $bebeficiary = $this->getDoctrine()->getRepository(Beneficiary::class)->findBy(['connectUser' => $user]);


        if ($formTransaction->isSubmitted() && $formTransaction->isValid()) {


            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            $array =  $request->request->get('form_transation');

            $bankId = $propertyAccessor->getValue($array, '[choixBank]');

            //dd($propertyAccessor->getValue($array, '[choixBank]'));


            $manager = $this->getDoctrine()->getManager();

            $bank = $this->getDoctrine()
                ->getRepository(Bank::class)
                ->find($bankId);


            $transaction->setConnectBank($bank);

            //$bank->addTransation($inforequest);

            $manager->persist($transaction);

            $manager->flush();
            return $this->redirectToRoute('virement');
        }

        return $this->render('detail_account/virement.html.twig', [
            'controller_name' => 'DetailAccountController',
            'banks' => $bank,
            'beneficiarys' => $bebeficiary,
            'form' => $formTransaction->createView()
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
