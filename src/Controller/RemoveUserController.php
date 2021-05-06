<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\DeleteUser;
use App\Form\FormDeleteUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RemoveUserController extends AbstractController
{
    #[Route('/remove', name: 'remove')]
    public function index(Request $request, ManagerRegistry $manager): Response
    {

        $delUser = new DeleteUser();
        $formDelete = $this->createForm(FormDeleteUserType::class, $delUser);
        $formDelete->handleRequest($request);

        if ($formDelete->isSubmitted() && $formDelete->isValid()) {

            //dd($formDelete['documentSuppression']->getData());

            $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->find($this->getUser()->getId());

            $manager = $this->getDoctrine()->getManager();


            /** @var UploadedFile $file */
            $file = $formDelete->get('documentSuppression')->getData();
            //génrer nouveau nom de fichier
            $renameFile = md5(uniqid()) . ' - '  . $user->getFirstname() . '.' . $file->guessExtension();
            //copie du fichier dans le dossier
            $file->move($this->getParameter('files_directory'), $renameFile);
            //stock image dans la base de donnée
            $delUser->setDocumentSuppression($renameFile);

            $delUser->setConnectUserDel($user);

            // ... persist the $product variable or any other work

            $manager->persist($delUser);
            $manager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('remove_user/removeUser.html.twig', [
            'controller_name' => 'RemoveUserController',
            'form' => $formDelete->createView()
        ]);
    }
}
