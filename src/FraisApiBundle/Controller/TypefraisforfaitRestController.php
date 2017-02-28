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

class TypefraisforfaitRestController extends FOSRestController
{
/*    
**
* @ApiDoc(
*  resource=true,
*  description="Get les id frais forfait"
* )
*/
    public function getLesidfraisforfaitAction()
    {
        $pdo = PdoGsb::getPdoGsb();
        $lesIdFrais = $pdo->getLesIdFrais();
        if(!$lesIdFrais)
            {
                // code erreur 404
                throw new NotFoundHttpException('Id Frais forfait non trouvés');
            }
        // retourne une réponse au format JSON et définit le content-type

        return new JsonResponse($lesIdFrais);
    }
}
