<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;

class ProductController extends AbstractController
{

    //Formulaire pour rentrer un equipement en base de donnée
    /**
     * @Route("/AjoutEquipement", name="product")
     */
    public function index(Request $request): Response
    {
        $em      = $this->getDoctrine()->getManager();
        $product = new Product();
        $form    = $this->createForm(ProductType::class, $product);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()){
            $em->persist($product);
            $em->flush();
        }

        return $this->render('product/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    //Accueil du site 
 /**
     * @Route("/HomeStock", name="producth")
     */
    public function accueil(): Response
    {


        return $this->render('product/accueil.html.twig');
    }


    //Affichage de tous les equipements
    /**
     * @Route("/Equipements", name="article")
     */
    public function showProduct(){

        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->findAll();

        if(!$product){
            throw $this->createNotFoundException('Pas de produit !');
        }
        return $this->render('product/all.html.twig', [
            'product' => $product
          ]);
    }


    //Affichage des informations en fonction de l'article selectionné 
    /**
     * @Route("/InfosEquipements/{id}", name="informations")
     */
    public function showProductDescription($id){

        $product = $this->getDoctrine()
        ->getRepository(Product::class)
        ->find($id);

        if(!$product){
            throw $this->createNotFoundException('Pas de produit !');
        }
        return $this->render('product/productdescription.html.twig', [
            'product' => $product
          ]);

        
    }
}