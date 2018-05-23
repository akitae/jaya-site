<?php

namespace UpjvBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\PoleDeCompetenceParcours;
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

    /** @var PoleDeCompetenceParcours */
    private $polesParcours;

    private $isChoix;

    /**
     * @Route("/choixUE", name="choix_ue")
     */
    public function indexAction () {

        /** @var Utilisateur $user */
        $this->user = $this->getUser();
        $message = array();

        $this->isChoix = false;

        if (!is_object($this->user) || !$this->user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if ($this->container->get('security.authorization_checker')->isGranted(Utilisateur::ROLE_ETUDIANT) == false) {
            return $this->redirectToRoute('upjv_homepage');
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

        /**
         * On vérifie que l'on se situe dans une période de choix.
         */
        if ($this->semestreToUse != null && $nowDate > $this->semestreToUse->getDateDebutChoix() && $nowDate < $this->semestreToUse->getDateFinChoix()) {
            $this->isChoix = true;
            $this->matieresOptionelles = $this->getMatieresOptTemp();

            /**
             * Si c'est la première fois que l'étudiant arrive sur cette page aucune données ne se trouve dans la table temporaire.
             * Dans ce cas on les insère.
             */
            if ($this->matieresOptionelles == null) {
                $this->matieresOptionelles = $this->insertMatieresOptTemp();
            } else {
                /**
                 * Dans le cas contraire on effectue une vérification d'intégritée.
                 * On vérifie qu'entre temps il n'y a pas eu de matière optionelle de rajouté.
                 */
                if (count($this->matieresOptionelles) != count($this->getMatieresOptByParcoursSemestre())) {
                    $this->deleteMatieresOptTemp($this->matieresOptionelles);
                    $this->matieresOptionelles = $this->insertMatieresOptTemp();
                }
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

            $this->poles = $this->sortPoles($this->poles);

            /**
             * On recherche le nombre de choix de disponible par pole suivant le parcours de l'étudiant.
             */
            $this->polesParcours = $this->getDoctrine()->getRepository(PoleDeCompetenceParcours::class)->findByParcours($this->user->getParcours());
        } else if ($this->semestreToUse != null && $nowDate > $this->semestreToUse->getDateFinChoix()) {
            $this->isChoix = false;
            /**
             * On récupère les matières final de l'utilisateur et on vérifie qu'elles appartiennent au semestre.
             */
            $matieresUtilisateur = $this->user->getMatieres();
            $matiereFinal = array();
            /** @var Matiere $matiere */
            foreach ($matieresUtilisateur as $matiere) {
                if ($matiere->getSemestre() == $this->semestreToUse) {
                    array_push($matiereFinal, $matiere);
                }
            }

            /**
             * On récupère uniquement les matières optionnelles.
             */
            $matiereOptFinal = array();
            /** @var Matiere $matiere */
            foreach ($matiereFinal as $matiere) {
                /** @var MatiereParcours $matiereParcours */
                $matiereParcours = $this->getDoctrine()->getRepository(MatiereParcours::class)->findByMatiereParcours($this->user->getParcours(), $matiere);
                if ($matiereParcours->getOptionnel()) {
                    array_push($matiereOptFinal, $matiere);
                }
            }

            /**
             * On récupère les pôles.
             */
            $this->poles = array();
            /** @var Matiere $matiere */
            foreach ($matiereOptFinal as $matiere) {
                array_push($this->poles, $matiere->getPoleDeCompetence());
            }

            /**
             * On rends unique la présence d'un pole.
             */
            $this->poles = array_unique($this->poles);

            $this->poles = $this->sortPoles($this->poles);

            $this->matieresOptionelles = $matiereOptFinal;
        }

        /**
         * Si l'utilisateur est administrateur on affiche un lien vers l'administration.
         */
        $isAdmin = $this->container->get('security.authorization_checker')->isGranted(Utilisateur::ROLE_ADMIN);
        $isEtudiant = $this->container->get('security.authorization_checker')->isGranted(Utilisateur::ROLE_ETUDIANT);

        return $this->render("UpjvBundle:UeChoice:index.html.twig", [
            "semestre" => $this->semestreToUse,
            "nowDate" => $nowDate,
            "poles" => $this->poles,
            "matieres" => $this->matieresOptionelles,
            "polesParcours" => $this->polesParcours,
            "isAdmin" => $isAdmin,
            "isEtudiant" => $isEtudiant,
            "isChoix" => $this->isChoix
        ]);
    }

    /**
     * Retourne les matières optionnelles du parcours et du semestre.
     */
    public function getMatieresOptByParcoursSemestre () {
        /**
         * On remonte toutes les UEs optionnelles disponible dans le parcours.
         */
        $listMatiereParcours = $this->getMatieresOptByParcours();

        /**
         * Pour toutes les matières optionnelles du parcours on vérifie qu'elle appartiennent au semestre en cours.
         */
        $matieres = array();
        /** @var MatiereParcours $parcoursMatiere */
        foreach ($listMatiereParcours as $parcoursMatiere) {
            /** @var Matiere $matiere */
            $matiere = $parcoursMatiere->getMatieres();
            if ($matiere->getSemestre() === $this->semestreToUse) {
                array_push($matieres, $matiere);
            }
        }

        return $matieres;
    }

    /**
     * Insère les matières optionnelles dans la base temporaire au premier affichage de la page.
     * Dans les cas suivants les valeurs sont récupéré de cette table temporaire.
     * @return mixed
     */
    private function insertMatieresOptTemp () {
        /**
         * On remonte toutes les UEs optionnelles disponible dans le parcours.
         */
        $listMatiereParcours = $this->getMatieresOptByParcours();

        /**
         * Pour toutes les matières optionnelles du parcours on vérifie qu'elle appartiennent au semestre en cours.
         */
        $matieres = array();
        $poles = array();
        /** @var MatiereParcours $parcoursMatiere */
        foreach ($listMatiereParcours as $parcoursMatiere) {
            /** @var Matiere $matiere */
            $matiere = $parcoursMatiere->getMatieres();
            if ($matiere->getSemestre() === $this->semestreToUse) {
                array_push($matieres, $matiere);
                /**
                 * On ajoute le pole de compétence dans un tableau pour ordonner par la suite les matières par pôle.
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

        return $this->getMatieresOptTemp();
    }

    /**
     * Trie les pôles suivant leur nom.
     * @param $poles
     * @return mixed
     */
    private function sortPoles ($poles) {

        usort($poles, function ($obj1, $obj2) {
            return strcmp($obj1->getNom(), $obj2->getNom());
        });

        return $poles;
    }

    /**
     * Retourne les matières optionelles par parcours.
     * @return mixed
     */
    private function  getMatieresOptByParcours () {
        return $this->getDoctrine()->getRepository(MatiereParcours::class)->findOptionelleByParcours($this->parcours);
    }

    /**
     * Retourne les choix optionelles de l'utilisateur.
     * @return mixed
     */
    private function getMatieresOptTemp () {
        return $this->getDoctrine()->getRepository(MatiereOptionelle::class)->findByUser($this->user);
    }

    /**
     * @param $matieresOptTemp
     */
    private function deleteMatieresOptTemp ($matieresOptTemp) {
        $em = $this->getDoctrine()->getManager();
        /** @var MatiereOptionelle $matiereTemp */
        foreach ($matieresOptTemp as $matiereTemp) {
            $em->remove($matiereTemp);
        }
        $em->flush();
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
                $matiere->setOrdre(intval($object['ordre']));

                $em->persist($matiere);
            }

            $em->flush();

            return new JsonResponse("Vos choix d'UE optionelles sont enregistrés.");
        } else {
            return $this->redirectToRoute("choix_ue");
        }

    }

}