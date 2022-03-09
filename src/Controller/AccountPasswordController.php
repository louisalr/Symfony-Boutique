<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    
    #[Route('/compte/modifier-mon-mot-de-passe', name: 'app_password')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher, ManagerRegistry $doctrine): Response
    {

        $notification = null;

        $user = $this->getUser(); //Pour obtenir l'utilisateur actuel
        $form = $this->createForm(ChangePasswordType::class, $user );

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $old_pwd = $form->get('old_password')->getData();
            
            //To check if the old_pwd matched the one in the database
            if($passwordHasher->isPasswordValid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData();

                $hashedPassword = $passwordHasher->hashPassword(
                    $user,
                    $new_pwd
                );

                $user->setPassword($hashedPassword);
                
                $this->entityManager->flush();

                $notification = "Votre mot de passe a bien été mis à jour.";
                $changed = true;
            }
            else{
                $notification = "Votre mot de passe actuel n'est pas correct";
                $changed = false;
            }
        }        

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification'=> $notification,
            'changed'=> $changed
        ]);
    }
}
