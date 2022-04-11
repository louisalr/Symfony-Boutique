<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAdressController extends AbstractController
{
    #[Route('/compte/adresses', name: 'app_account_address')]
    public function index(): Response
    {
        return $this->render('account_adress/index.html.twig');
    }

    #[Route('/compte/ajouter-une-adresse', name: 'app_account_add')]
    public function add(Request $request, ManagerRegistry $doctrine): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $address->setUser($this->getUser());

            $entityManager = $doctrine->getManager();
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account_adress/adress_add.html.twig', [
            'form_address' => $form->createView()
        ]);
    }

    #[Route('/compte/modifier-une-adresse/{id}', name: 'app_account_edit')]
    public function change($id, Request $request, ManagerRegistry $doctrine): Response
    {
        $address = $doctrine->getRepository(Address::class)->findOneById($id);

        //si l'adresse n'existe pas, on redirige l'utilisateur vers la liste de ses adresses 
        if(!$address || $address->getUser() != $this->getUser()){
            return $this->redirectToRoute('app_account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $doctrine->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('app_account_address');
        }

        return $this->render('account_adress/adress_add.html.twig', [
            'form_address' => $form->createView()
        ]);
    }

    #[Route('/compte/supprimer-une-adresse/{id}', name: 'app_account_delete')]
    public function delete($id, ManagerRegistry $doctrine): Response
    {
        $address = $doctrine->getRepository(Address::class)->findOneById($id);

        //pour vérifier si l'adresse existe et qu'elle correspond bien à l'utilisateur courant
        if($address && $address->getUser() == $this->getUser()){
            $entityManager = $doctrine->getManager();
            $entityManager->remove($address);
            $entityManager->flush();
        }
            
        return $this->redirectToRoute('app_account_address');
    }
}
