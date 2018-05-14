<?php

namespace UpjvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\DTO\EmailWrapper;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\EmailType;
use Zend\Code\Scanner\Util;

class EmailUserController extends Controller
{

    /**
     * @Route("/admin/envoiEmail", name="admin_envoi_email")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction (Request $request) {

        /** @var EmailWrapper $emailWrapper */
        $emailWrapper = new EmailWrapper();

        $form = $this->createForm(EmailType::class, $emailWrapper, array(
            'em' => $this->getDoctrine()->getManager()
        ));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var EmailWrapper $emailWrapper */
            $emailWrapper = $form->getData();

            $arrayIdParcours = $emailWrapper->getListParcours();
            $arrayIdMatiere = $emailWrapper->getListMatiere();
            $arrayIdGroupe = $emailWrapper->getListGroupe();

            $object = $emailWrapper->getObject();
            $message = $emailWrapper->getMessage();

            if ($arrayIdParcours != null && count($arrayIdMatiere) == 0) {
                //var_dump("parcours");
                /** @var array $listParcours */
                $listParcours = $this->getParcoursById($arrayIdParcours);

                /** @var array $listUtlisateur */
                $listUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findUtilisateurByParcours($listParcours);

                /** @var array $listEmail */
                $listEmail = $this->getEmailFromUser($listUtilisateur);

                //var_dump($listEmail);

                $this->sendMailToUser($object, $this->getFromForMail(), $listEmail,$message);
            } else if ($arrayIdParcours != null && count($arrayIdParcours) != 0 && $arrayIdMatiere != null && count($arrayIdMatiere) != 0 && ($arrayIdGroupe == null || count($arrayIdGroupe) == 0)) {
                //var_dump("matiere");
                /** @var array $listMatiere */
                $listMatiere = $this->getMatieresById($arrayIdMatiere);

                /** @var array $listUtilisateur */
                $listUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findUserByMatieres($listMatiere);

                /** @var array $listEmail */
                $listEmail = $this->getEmailFromUser($listUtilisateur);

                //var_dump($listEmail);

                $this->sendMailToUser($object, $this->getFromForMail(), $listEmail,$message);
            } else if ($arrayIdParcours != null && count($arrayIdParcours) != 0 && $arrayIdMatiere != null && count($arrayIdMatiere) != 0 && $arrayIdGroupe != null && count($arrayIdGroupe) != 0) {
                //var_dump("groupe");
                /** @var array $listGroupe */
                $listGroupe = $this->getGroupesByid($arrayIdGroupe);

                /** @var array $listUtilisateur */
                $listUtilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findUserByGroupes($listGroupe);

                /** @var array $listEmail */
                $listEmail = $this->getEmailFromUser($listUtilisateur);

                //var_dump($listEmail);

                $this->sendMailToUser($object, $this->getFromForMail(), $listEmail,$message);
            }
        }

        return $this->render("@Upjv/Admin/EmailUser/index.html.twig", [
            'form' => $form->createView()
        ]);
    }

    private function getEmailFromUser ($listUtilisateur) {
        /** @var array $listEmail */
        $listEmail = array();
        /** @var Utilisateur $utilisateur */
        foreach ($listUtilisateur as $utilisateur) {
            array_push($listEmail, $utilisateur->getEmail());
        }

        return $listEmail;
    }

    private function getFromForMail () {
        return $from = key($this->container->getParameter('fos_user.registration.confirmation.from_email'));
    }

    private function sendMailToUser ($object, $from, $listTo, $body) {
        //var_dump('sendmail');
        $message = (new \Swift_Message($object))
            ->setFrom($from)
            ->setBcc($listTo)
            ->setBody($body, 'text/html');

        $this->get('mailer')->send($message);
    }

    private function getParcoursById ($arrayIdParcours) {
        $arrayParcours = array();
        foreach ($arrayIdParcours as $idParcours) {
            array_push($arrayParcours, $this->getDoctrine()->getRepository(Parcours::class)->find($idParcours));
        }

        return $arrayParcours;
    }

    private function getMatieresById ($arrayIdMatiere) {
        /** @var array $arrayMatiere */
        $arrayMatiere = array();
        foreach ($arrayIdMatiere as $idMatiere) {
            array_push($arrayMatiere, $this->getDoctrine()->getRepository(Matiere::class)->find($idMatiere));
        }

        return $arrayMatiere;
    }

    private function getGroupesByid ($arrayIdGroupe) {
        /** @var array $arrayGroupe */
        $arrayGroupe = array();
        foreach ($arrayIdGroupe as $idGroupe) {
            array_push($arrayGroupe, $this->getDoctrine()->getRepository(Groupe::class)->find($idGroupe));
        }

        return $arrayGroupe;
    }

    /**
     * @Route("/admin/selectMatiere", name="admin_select_matiere")
     * @param $arrayParcours
     * @return mixed
     */
    public function selectMatiere (Request $request) {
        $arrayIdParcours = $request->request->get('array_Parcours');

        $jsonArrayMatiere = array();

        if ($arrayIdParcours != null) {
            /**
             * On recherche les parcours via leur Ids
             */
            /** @var array $arrayParcours */
            $arrayParcours = array();
            foreach ($arrayIdParcours as $idParcours) {
                array_push($arrayParcours, $this->getDoctrine()->getRepository(Parcours::class)->find($idParcours));
            }

            /**
             * On récupère toutes les relations entre les matières et les parcours.
             */
            $matieresParcours = $this->getDoctrine()->getRepository(MatiereParcours::class)->findMatieresByParcours($arrayParcours);

            /**
             * De ces relations on récupère toutes ces matières.
             */
            $arrayMatiere = array();
            /** @var MatiereParcours $matiereParcours */
            foreach ($matieresParcours as $matiereParcours) {
                array_push($arrayMatiere, $matiereParcours->getMatieres());
            }

            /** @var Matiere $matiere */
            foreach ($arrayMatiere as $matiere) {
                array_push($jsonArrayMatiere, [
                    "id" => $matiere->getId(),
                    "nom" => $matiere->getNom()
                ]);
            }
        }

        return new JsonResponse($jsonArrayMatiere);
    }

    /**
     * @Route("/admin/selectGroupe", name="admin_select_groupe")
     * @param Request $request
     * @return JsonResponse
     */
    public function selectGroupe (Request $request) {
        $arrayIdMatiere = $request->request->get('array_Matiere');

        $jsonArrayGroupe = array();

        if ($arrayIdMatiere != null) {
            /**
             * On récupère toutes les matières.
             */
            /** @var array $arrayMatiere */
            $arrayMatiere = array();
            foreach ($arrayIdMatiere as $idMatiere) {
                array_push($arrayMatiere, $this->getDoctrine()->getRepository(Matiere::class)->find($idMatiere));
            }

            /**
             * On récupère la liste des groupes de toutes les matières.
             */
            $listGroupe = $this->getDoctrine()->getRepository(Groupe::class)->findByMatiere($arrayMatiere);

            /**
             * On construit l'objet JSOn pour le retour.
             */
            /** @var Groupe $groupe */
            foreach ($listGroupe as $groupe) {
                array_push($jsonArrayGroupe, [
                    "id" => $groupe->getId(),
                    "nom" => $groupe->getNom()
                ]);
            }
        }

        return new JsonResponse($jsonArrayGroupe);
    }

}