<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\User;
use App\Entity\Beneficiary;
use App\Entity\Transaction;
use App\Form\FormTransationType;
use function Symfony\Component\String\s;
use App\Repository\TransactionRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class DetailAccountController extends AbstractController
{


    #[Route('/detailaccount/virement', name: 'virement')]
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
            $beneficiaryId = $propertyAccessor->getValue($array, '[choixBeneficiary]');

            $debit = $propertyAccessor->getValue($array, '[debit]');
            $debit = (float) s($debit)->replace(",", ".")->toString();

            $manager = $this->getDoctrine()->getManager();

            $bank = $this->getDoctrine()
                ->getRepository(Bank::class)
                ->find($bankId);

            $beneficiary = $this->getDoctrine()
                ->getRepository(Beneficiary::class)
                ->find($beneficiaryId);

            $transaction->setConnectBank($bank);
            $transaction->setBeneficiaryTransaction($beneficiary);
            $transaction->setCreatedAt(new \DateTime());

            $balanceNow = $bank->getBankBalance();
            $newBalance = $balanceNow - $debit;

            $bank->setBankBalance($newBalance);

            $manager->persist($transaction);
            $manager->flush();
            return $this->redirectToRoute('detailAccount', array('id' => $bankId));
        }

        return $this->render('detail_account/virement.html.twig', [
            'controller_name' => 'DetailAccountController',
            'banks' => $bank,
            'beneficiarys' => $bebeficiary,
            'form' => $formTransaction->createView(),
            'validation_user' => $user->getValidation()
        ]);
    }


    #[Route('/detailaccount/{id}', name: 'detailAccount')]
    public function index($id, PaginatorInterface $paginator, TransactionRepository $repository, Request $request): Response
    {

        $bank = $this->getDoctrine()
            ->getRepository(Bank::class)
            ->find($id);

        $queryBuilder = $repository->getQueryBuilderByBankId($bank->getId());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('detail_account/details.html.twig', [
            'controller_name' => 'DetailAccountController',
            'bank' => $bank,
            'pagination' => $pagination
        ]);
    }

}
