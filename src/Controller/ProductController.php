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

 /**
     * @Route("/HomeStock", name="producth")
     */
    public function accueil(): Response
    {


        return $this->render('product/accueil.html.twig');
    }

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
    /**
     * @Route("/InfosEquipements/{id}", name="article2")
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

        //return new Response($product->getName());
    }
}