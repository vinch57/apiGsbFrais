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

class FraishorsforfaitRestController extends FOSRestController {

    public function getFraishorsforfaitMoisAction($idVisiteur, $mois) {
        $pdo = PdoGsb::getPdoGsb();
        $lesFraisHorsforfait = $pdo->getLesFraisHorsforfait($idVisiteur, $mois);

        if (!$lesFraisHorsforfait) {
            throw new NotFoundHttpException('Frais Hors forfait non dispo !');
        }

        return new JsonResponse($lesFraisHorsforfait);
    }
    
    
    public function getFraishorsforfaittotauxAction($idVisiteur) {
        $pdo = PdoGsb::getPdoGsb();
        $lesFraisHorsForfaitTotaux = $pdo->getLesFraisHorsForfaitTotaux($idVisiteur);
        
        if(!$lesFraisHorsForfaitTotaux) {
            throw new NotFoundHttpException('Frais hors forfait totaux non disponibles ! [idVisiteur='.$idVisiteur.']');
        }
        
        return new JsonResponse($lesFraisHorsForfaitTotaux);
    }

    public function postFraishorsforfaitAction(Request $request) {
        $pdo = PdoGsb::getPdoGsb();
        // récupérer les paramètres passés par POST dans l'objet $request
        $idVisiteur = $request->request->get('idVisiteur');
        $mois = $request->request->get('mois');
        $libelle = $request->request->get('libelle');
        $date = $request->request->get('date');
        $montant = $request->request->get('montant');
        $client = $request->request->get('client');
        // appeler la méthode de mise à jour de la classe pdogsb
        $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant, $client);
        // répondre au client
        $response = new Response();
        $statusCode = 201; // created, liste des codes ici http://www.codeshttp.com/
        $response->setStatusCode($statusCode); // created
        return $response;
    }

    public function deleteFraishorsforfaitAction(Request $request) {
        $pdo = PdoGsb::getPdoGsb();
        // récupérer les paramètres passés par DELETE dans l'objet $request
        $idFrais = $request->request->get('idFrais');

        // appeler la méthode de mise à jour de la classe pdogsb
        $pdo->supprimerFraisHorsForfait($idFrais);
        // répondre au client
        $response = new Response();
        $statusCode = 200; // created, liste des codes ici http://www.codeshttp.com/
        $response->setStatusCode($statusCode); // created
        return $response;
    }
    
    public function getTotauxfraisparclientAction($idVisiteur)
    {
        $pdo = PdoGsb::getPdoGsb();
        $totauxFraisHorsForfaitClient = $pdo->getLesFraisHorsForfaitClientTotaux($idVisiteur);
        return new JsonResponse($totauxFraisHorsForfaitClient);
    }
    
    public function getLesclientsvisiteurAction($idVisiteur)
    {
        $pdo = PdoGsb::getPdoGsb();
        $lesClientsVisiteur = $pdo->getLesClientsVisiteur($idVisiteur);
        return new JsonResponse($lesClientsVisiteur);
    }

}
