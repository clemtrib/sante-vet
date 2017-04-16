<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        //default/index.html.twig
        return $this->render('default/index.html.twig');
    }
    
    /**
     * @Route("/test")
     */
    public function testAction(Request $request)
    {
        die;
    }
}
