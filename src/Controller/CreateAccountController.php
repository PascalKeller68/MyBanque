<?php

namespace App\Controller;

use App\Entity\Bank;
use App\Entity\User;
use App\Entity\Roles;
use App\Form\CreateAccountType;
use App\Repository\RolesRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class CreateAccountController extends AbstractController
{

    #[Route('/creercompte', name: 'createaccount')]
    public function registration(Request $request, ManagerRegistry $manager, UserPasswordEncoderInterface $encoder)
    {

        $user = new User();


        $rolesRepository = $this->getDoctrine()->getRepository(Roles::class);
        $role = $rolesRepository->findOneBy(['roleName' => 'ROLE_USER']);

        $user->addRolesUtilisateur($role);

        //Creation de compte bancaire
        $bank = new Bank();
        $bank->setBankName('Compte Courant');
        $bank->setBankBalance(1500);


        $bankA = new Bank();
        $bankA->setBankName('Livret A');
        $bankA->setBankBalance(2500);

        $formRegistration = $this->createForm(CreateAccountType::class, $user);

        $formRegistration->handleRequest($request);
        // $user->setRole(1);
        $user->getRolesUtilisateur(1);
        $user->setValidation(false);

        if ($formRegistration->isSubmitted() && $formRegistration->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager = $this->getDoctrine()->getManager();

            /** @var UploadedFile $file */
            $file = $formRegistration->get('identityFile')->getData();
            //génrer nouveau nom de fichier
            $renameFile = md5(uniqid()) . '-'  . $user->getFirstname() . '.' . $file->guessExtension();
            //copie du fichier dans le dossier
            $file->move($this->getParameter('identity_directory'), $renameFile);
            //stock image dans la base de donnée
            $user->setIdentityFile($renameFile);


            $manager->persist($bank);
            $manager->persist($bankA);

            $user->addBank($bank);
            $user->addBank($bankA);
            $manager->persist($user);

            $manager->flush();
            return $this->redirectToRoute('newLogin');
        }

        return $this->render(
            'create_account\registration.html.twig',
            ['form' => $formRegistration->createView()]
        );
    }

    #[Route('/connexion', name: 'newLogin')]
    public function newLogin(AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $mail = $authenticationUtils->getLastUsername();

        return $this->render(
            'create_account\login.html.twig',
            [
                'mail' => $mail,
                'error' => $error,
            ]
        );
    }

    #[Route('/deconnexion', name: 'Logout')]
    public function logout()
    {
    }
}
