<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of LeboncoinController
 *
 * @author Clément
 */
class LeboncoinController extends Controller {
    /**
     * @Route("/le/boncoin")
     */
    public function numberAction()
    {
        $products = $this->get('app.leboncoin')->getList(
            'rhone_alpes',
            'animaux',
            100
        );
        return $this->render('default/products.html.twig', array(
            "products" => $products
        ));
    }
}
