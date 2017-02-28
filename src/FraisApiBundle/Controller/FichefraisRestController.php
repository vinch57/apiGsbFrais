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

class FichefraisRestController extends FOSRestController
{
        /**
     * @ApiDoc(resource=true, description="Get les mois disponibles pour un visiteur")
     */
    public function getLesmoisdisponiblesAction($idVisiteur) {
        $pdo = PdoGsb::getPdoGsb();
        $lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
        
        if(!$lesMois)
        {
            throw new NotFoundHttpException('Mois non disponibles [idVisiteur='.$idVisiteur.']');
        }

        return new JsonResponse($lesMois);
    }
    
    public function getLesanneesdisponiblesAction($idVisiteur) {
        $pdo = PdoGsb::getPdoGsb();
        $lesAnnees = $pdo->getLesAnneesDisponibles($idVisiteur);
        
        if(!$lesAnnees)
        {
            throw new NotFoundHttpException('Années non disponibles [idVisiteur='.$idVisiteur.']');
        }

        return new JsonResponse($lesAnnees);
    }
    
    public function getLesfraisannuelsAnneeAction($idVisiteur, $annee) {
        $pdo = PdoGsb::getPdoGsb();
        $lesFraisAnnuels = $pdo->getLesFraisAnnuels($idVisiteur, $annee);
        
        if(!$lesFraisAnnuels)
        {
            throw new NotFoundHttpException('Années non disponibles [idVisiteur='.$idVisiteur.']');
        }
        
        return new JsonResponse($lesFraisAnnuels);
    }
    
    public function getNbjustificatifsMoisAction($idVisiteur, $mois) {
        $pdo = PdoGsb::getPdoGsb();
        $nbJustificatifs = $pdo->getNbjustificatifs($idVisiteur, $mois);
        
        if(!$nbJustificatifs)
        {
            throw new NotFoundHttpException('Nombre de justificatifs non disponible [idVisiteur='.$idVisiteur.']' .'[mois='.$mois.']');
        }

        return new JsonResponse($nbJustificatifs);
    }
    
    public function getEstpremierfraisMoisAction($idVisiteur, $mois) {
        $pdo = PdoGsb::getPdoGsb();
        $estPremierFraisMois = $pdo->estPremierFraisMois($idVisiteur, $mois);
        
        if(!$estPremierFraisMois)
        {
            throw new NotFoundHttpException('Pas de fiche de frais pour le visiteur et le mois [idVisiteur='.$idVisiteur.']' .'[mois='.$mois.']');
        }

        return new JsonResponse($estPremierFraisMois);
    }
    
    
    public function postFichefraisAction(Request $request) {
        $pdo = PdoGsb::getPdoGsb();
        $idVisiteur = $request->request->get('idVisiteur');
        $mois = $request->request->get('mois');
        $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
        
        $response = new Response();
        $statusCode = 201;
        $response->setStatusCode($statusCode);
        return $response;
    }
}
