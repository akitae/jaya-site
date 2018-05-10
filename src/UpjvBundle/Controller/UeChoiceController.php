<?php

namespace UpjvBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\Semestre;
use UpjvBundle\Entity\Utilisateur;

class UeChoiceController extends Controller
{

    /** @var Utilisateur */
    private $user;

    /** @var Semestre */
    private $semestreToUse;

    /** @var Parcours */
    private $parcours;

    /** @var PoleDeCompetence */
    private $poles;

    /** @var MatiereOptionelle */
    private $matieresOptionelles;

    /**
     * @Route("/choixUE", name="choix_ue")
     */
    public function indexAction () {

        /** @var Utilisateur $user */
        $this->user = $this->getUser();
        $message = array();


        if ($this->user == null) {
            return $this->redirectToRoute('fos_user_security_login');
        }

        if ($this->user->getParcours() == null) {
            array_push($message, "Vous ne possédez pas de parcous. Veuillez contacter l'administration.");
        }

        /** @var Parcours $parcours */
        $this->parcours = $this->user->getParcours();

        $semestres = $this->parcours->getSemestres();

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
                    $this->semestreToUse = $semestre;
                }
            }
        }

        if ($this->semestreToUse != null && $nowDate > $this->semestreToUse->getDateDebutChoix() && $nowDate < $this->semestreToUse->getDateFinChoix()) {

            $this->matieresOptionelles = $this->getMatieresOptionelles();

            if ($this->matieresOptionelles == null) {
                $this->matieresOptionelles = $this->insertMatiereOptionelle();
            }

            /**
             * On récupère les pôles.
             */
            $this->poles = array();
            /** @var MatiereOptionelle $matieresOptionelle */
            foreach ($this->matieresOptionelles as $matieresOptionelle) {
                array_push($this->poles, $matieresOptionelle->getMatiere()->getPoleDeCompetence());
            }
            /**
             * On rends unique la présence d'un pole.
             */
            $this->poles = array_unique($this->poles);

        }

        return $this->render("UpjvBundle:UeChoice:index.html.twig", [
            "semestre" => $this->semestreToUse,
            "nowDate" => $nowDate,
            "poles" => $this->poles,
            "matieres" => $this->matieresOptionelles
        ]);
    }

    /**
     * Insère les matières optionnelles dans la base temporaire au premier affichage de la page.
     * Dans les cas suivants les valeurs sont récupéré de cette table temporaire.
     * @return mixed
     */
    private function insertMatiereOptionelle () {
        /**
         * On remonte toutes les UEs optionnelles de l'étudiant.
         */
        $listMatiereParcours = $this->getDoctrine()->getRepository(MatiereParcours::class)->findOptionelleByParcours($this->parcours);


        /**
         * Pour toutes les matières optionnelles du parcours on vérifie qu'elle appartiennent au semestre en cours.
         */
        $matieres = array();
        $poles = array();
        /** @var MatiereParcours $parcoursMatiere */
        foreach ($listMatiereParcours as $parcoursMatiere) {
            /** @var Matiere $matiere */
            $matiere = $parcoursMatiere->getMatieres();
            if ($matiere->getSemestre() == $this->semestreToUse) {
                array_push($matieres, $matiere);
                /**
                 * On ajoute le pole de compétence dans un tableau.
                 */
                array_push($poles, $matiere->getPoleDeCompetence());
            }
        }

        /**
         * On récupère les pôles de compétence de manière unique.
         */
        $poles = array_unique($poles);

        /**
         * On crée l'ordonnancement temporaire des choix et on persist.
         */
        $em = $this->getDoctrine()->getManager();
        $matieresOptionelles = array();
        /** @var PoleDeCompetence $pole */
        foreach ($poles as $pole) {
            /** @var int $index */
            $index = 1;
            /** @var Matiere $matiere */
            foreach ($matieres as $matiere) {
                if ($matiere->getPoleDeCompetence() == $pole) {
                    /** @var MatiereOptionelle $matieresOptionelle */
                    $matieresOptionelle = new MatiereOptionelle();
                    $matieresOptionelle->setMatiere($matiere);
                    $matieresOptionelle->setUser($this->user);
                    $matieresOptionelle->setOrdre($index);

                    $index++;

                    $em->persist($matieresOptionelle);
                }
            }
        }

        $em->flush();

        return $this->getMatieresOptionelles();
    }

    /**
     * Retourne les choix optionelles de l'utilisateur.
     * @return mixed
     */
    private function getMatieresOptionelles () {
        return $this->getDoctrine()->getRepository(MatiereOptionelle::class)->findByUser($this->user);
    }

    /**
     * @Route("/choixUe/enregistrer/", name="save_choice_ue")
     * @Method({"GET", "POST"})
     */
    public function saveChoiceUe (Request $request) {
        $arrayMatiere = $request->request->get('array_Matiere');

        if ($arrayMatiere != null) {
            $em = $this->getDoctrine()->getManager();
            foreach ($arrayMatiere as $object) {
                $matiere = $em->getRepository(MatiereOptionelle::class)->find($object["id"]);
                $matiere->setOrdre($object['ordre']);

                $em->persist($matiere);
            }

            $em->flush();

            return new JsonResponse("Vos choix d'UE optionelles sont enregistrés.");
        } else {
            return $this->redirectToRoute("choix_ue");
        }

    }

}