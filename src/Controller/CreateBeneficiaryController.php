<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Beneficiary;
use App\Form\AddBeneficiaryType;
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
        $beneficiary = new Beneficiary();
        $formBeneficiary = $this->createForm(AddBeneficiaryType::class, $beneficiary);

        $formBeneficiary->handleRequest($request);


        if ($formBeneficiary->isSubmitted() && $formBeneficiary->isValid()) {

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($this->getUser()->getId());

            $beneficiary->setValidation(0);
            $user->addBeneficiary($beneficiary);

            $manager = $this->getDoctrine()->getManager();

            $manager->persist($beneficiary);
            $manager->persist($user);

            $manager->flush();
            return $this->redirectToRoute('create_beneficiary');
        }



        return $this->render('create_beneficiary/beneficiary.html.twig', [
            'controller_name' => 'CreateBeneficiaryController',
            'form' => $formBeneficiary->createView()
        ]);
    }
}
