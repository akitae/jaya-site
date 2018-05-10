<?php

namespace UpjvBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
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

            $matieresOptionelles = $this->getMatieresOptionelles();

            if ($matieresOptionelles == null) {
                $matieresOptionelles = $this->insertMatiereOptionelle();
            }

            /**
             * On récupère les pôles.
             */
            $poles = array();
            /** @var MatiereOptionelle $matieresOptionelle */
            foreach ($matieresOptionelles as $matieresOptionelle) {
                //var_dump($matieresOptionelle->getMatiere()->getNom());
                array_push($poles, $matieresOptionelle->getMatiere()->getPoleDeCompetence());
            }
            /**
             * On rends unique la présence d'un pole.
             */
            $poles = array_unique($poles);



        }







        return $this->render("UpjvBundle:UeChoice:index.html.twig", [
            "semestre" => $this->semestreToUse,
            "nowDate" => $nowDate,
            "poles" => $poles,
            "matieres" => $matieresOptionelles
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
         * On récupère ensuite uniquement celle du semestre.
         */
        $matieresOptionelles = array();
        /** @var MatiereParcours $parcoursMatiere */
        foreach ($listMatiereParcours as $parcoursMatiere) {
            /** @var Matiere $matiere */
            $matiere = $parcoursMatiere->getMatieres();
            if ($matiere->getSemestre() == $this->semestreToUse) {
                array_push($matieresOptionelles, $matiere);
            }
        }

        /**
         * Pour finir on crée les entités matières optionelles que l'on persist.
         */
        $index = 1;
        $em = $this->getDoctrine()->getManager();
        /** @var Matiere $matiere */
        foreach ($matieresOptionelles as $matiere) {

            /** @var MatiereOptionelle $matieresOptionelle */
            $matieresOptionelle = new MatiereOptionelle();
            $matieresOptionelle->setMatiere($matiere);
            $matieresOptionelle->setUser($this->user);
            $matieresOptionelle->setOrdre($index);

            $em->persist($matieresOptionelle);

            $index++;
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
     * @Route("/choixUe/position/{id}/{position}", name="choix_ue_position")
     * @Method({"GET"})
     * @param $id integer
     * @param $position integer
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sortPosition ($id, $position) {

        $em = $this->getDoctrine()->getManager();
        $matiereOptionelle = $em->getRepository(MatiereOptionelle::class)->find($id);
        $matiereOptionelle->setOrdre($position);
        $em->persist($matiereOptionelle);
        $em->flush();

        $request = new Request();

        return $this->indexAction($request);
    }

}