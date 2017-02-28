<?php

namespace FraisApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PdoGsb;

class FraisforfaitRestController extends FOSRestController {
    
    public function getFraisforfaitMoisAction($idVisiteur, $mois) {
        $pdo = PdoGsb::getPdoGsb();
        $lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $mois);
        
        if(!$lesFraisForfait) {
            throw new NotFoundHttpException('Frais forfait non disponibles ! [idVisiteur='.$idVisiteur.']' .'[mois='.$mois.']');
        }
        
        return new JsonResponse($lesFraisForfait);
    }
    
    public function getFraisforfaittotauxAction($idVisiteur) {
        $pdo = PdoGsb::getPdoGsb();
        $lesFraisForfaitTotaux = $pdo->getLesFraisForfaitTotaux($idVisiteur);
        
        if(!$lesFraisForfaitTotaux) {
            throw new NotFoundHttpException('Frais forfait totaux non disponibles ! [idVisiteur='.$idVisiteur.']');
        }
        
        return new JsonResponse($lesFraisForfaitTotaux);
    }
    
    public function putMajfraisforfaitAction(Request $request) {
        $pdo = PdoGsb::getPdoGsb();
        $idVisiteur = $request->request->get('idVisiteur');
        $mois = $request->request->get('mois');
        $lesFrais = $request->request->get('lesFrais');
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        
        $response = new Response();
        $statusCode = 201;
        $response->setStatusCode($statusCode);
        return $response;
    }
    
}