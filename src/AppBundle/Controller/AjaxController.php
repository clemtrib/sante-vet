<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller {

    /**
     * @Route("/ajax/visit/{id}", name="ajax_visit")
     */
    public function visitAction($id) {
        
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:ProductEntity');
        $productEntity = $repository->find($id);
        $visit = $productEntity->getVisit();
        $productEntity->setVisit($visit + 1);
        $em->persist($productEntity);
        $em->flush();

        return new Response(json_encode(array(
            'success' => true,
            'errCode' => 200,
            'message' => "Votre visite a bien été comptabilisée !"
        )));
        
    }

}
