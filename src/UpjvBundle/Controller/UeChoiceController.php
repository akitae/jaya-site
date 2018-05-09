<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 08/05/2018
 * Time: 18:42
 */

namespace UpjvBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\Semestre;
use UpjvBundle\Entity\Utilisateur;

class UeChoiceController extends Controller
{

    /**
     * @Route("/choixUE", name="choix_ue")
     */
    public function indexAction () {

        /** @var Utilisateur $user */
        $user = $this->getUser();
        $message = array();

        /** @var Semestre $semestreToUse */
        $semestreToUse = null;

        if ($user == null) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        if ($user->getParcours() == null) {
            array_push($message, "Vous ne possédez pas de parcous. Veuillez contacter l'administration.");
        }

        /** @var Parcours $parcours */
        $parcours = $user->getParcours();

        $semestres = $parcours->getSemestres();

        /**
         * On vérifie d'abord que l'on se situe dans un semestre.
         */
        $nowDate = new \DateTime();
        /** @var Semestre $semestre */
        foreach ($semestres as $semestre) {
            // On compare déjà la date de début.
            $dateDebut = $semestre->getDateDebut();

            if ($nowDate > $dateDebut) {
                $dateFin = $semestre->getDateFin();
                if ($nowDate < $dateFin) {
                    $semestreToUse = $semestre;
                }
            }
        }

        /**
         * On remonte toutes les UEs optionnelles de l'étudiant.
         */
        //$matieres = $this->getDoctrine()->getRepository(MatiereParcours::)

        return $this->render("UpjvBundle:UeChoice:index.html.twig", [
            "semestre" => $semestreToUse,
            "nowDate" => $nowDate
        ]);
    }
}