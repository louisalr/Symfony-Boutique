<?php

namespace App\Class;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class Cart{

    //To use session with Symfony 6.0
    private $requestStack;

    public function __construct(RequestStack $requestStack, ManagerRegistry $doctrine)
    {
        $this->requestStack = $requestStack;
        $this->doctrine = $doctrine;
    }

    //to get all the products in the shopping cart
    public function getFull(){
        $entityManager = $this->doctrine->getManager();

        $cartInformations = [];

        //call the function get() to check if there are items in shopping cart
        if($this->get()){
            foreach($this->get() as $id => $quantity)
            {
                $product_objet = $entityManager->getRepository(Product::class)->findOneById($id);
                
                //si le produit n'existe pas, on le supprime du panier
                if(!$product_objet){
                    $this->delete($id);
                    continue; 
                }

                $cartInformations[] = [
                    'product' => $product_objet,
                    'quantity' => $quantity,
                ];
            }
        }

        return $cartInformations;
    }
    
    //Add an element in the session
    //Receive the id of the product
    public function add($id)
    {
        //to get the current Session
        $session = $this->requestStack->getSession();

        //Get the current array of cart ['id', 'number'];
        $cart = $session->get('cart', []);

        //Increment the number of the product if already in the shopping cart
        if(!empty($cart[$id])){
            $cart[$id]++;
        }
        else{
            $cart[$id]=1;
        }

        $session->set('cart',$cart);
    }

    //Get all the elements in session cart
    public function get(){
        $session = $this->requestStack->getSession();

        return $session->get('cart');
    }

    //Remove all the elements in session cart
    public function remove(){
        $session = $this->requestStack->getSession();

        return $session->remove('cart');
    }

     //Remove one of the elements in session cart
     public function delete($id){
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        unset($cart[$id]); //remove the product in the array

        return $session->set('cart', $cart); //update the new cart without the deleted value
    }

    public function decrease($id){
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart', []);

        //if there's more than one product, we only need to decrease
        if($cart[$id]>1){
            $cart[$id]--;
        }//we need to remove the product in the shopping cart
        else{
            unset($cart[$id]);
        }

        return $session->set('cart', $cart); //update the new cart without the deleted value

    }
}