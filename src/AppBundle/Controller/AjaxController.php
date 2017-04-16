<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Form\ProductSearchType;
use AppBundle\Entity\ProductSearchEntity as ProductSearchEntity;

class DefaultController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
         
        $productSearch = new ProductSearchEntity();
        
        $form = $this->createForm(
                ProductSearchType::class, 
                $productSearch, 
                array(
                    'action' => $this->generateUrl('leboncoin'),
                    'method' => 'POST'
                )
            );
        
        $repository = $em->getRepository('AppBundle:ProductEntity');
                
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $productSearch = $form->getData();
            
        }
        
        $products = $repository->findAllOrderBy(
                'price',
                (string) $productSearch->getLabel() ?? null,
                (int) $productSearch->getMin() ?? null,
                (int) $productSearch->getMax() ?? null
            );


        return $this->render('default/productsWithFilters.html.twig', array(
            'products' => $products,
            'form' => $form->createView()
        ));
        
    }
    
    /**
     * @Route("/from/leboncoin", name="leboncoin")
     */
    public function listAction()
    {
        $products = $this->get('app.leboncoin')->getProductEntities(
            'rhone_alpes',
            'animaux',
            100
        );
        return $this->render('default/productsWithoutFilters.html.twig', array(
            "products" => $products
        ));
    }

}
