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
     */
    public function indexAction (Request $request) {
        /** @var EmailWrapper $emailWrapper */
        $emailWrapper = new EmailWrapper();
        $form = $this->createForm(EmailType::class, $emailWrapper, array(
            'em' => $this->getDoctrine()->getManager()
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            /** @var EmailWrapper $emailWrapper */
            $emailWrapper = $form->getData();
            $arrayIdParcours = $emailWrapper->getListParcours();
            $arrayIdMatiere = $emailWrapper->getListMatiere();
            $arrayIdGroupe = $emailWrapper->getListGroupe();
            if ($arrayIdParcours != null && count($arrayIdMatiere) == 0) {
                $listParcours = $this->getMatiereByParcours($arrayIdParcours);
                $listUtlisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findUtilisateurByParcours($listParcours);
                var_dump($listUtlisateur);
                $message = (new \Swift_Message('Hello'))
                    ->setFrom('no-replay@jaya.com')
                    ->setTo('florian.lephore@outlook.com')
                    ->setBody('aaa', 'text/html');
                $this->get('mailer')->send($message);
            }
        }
        return $this->render("@Upjv/Admin/EmailUser/index.html.twig", [
            'form' => $form->createView()
        ]);
    }
    private function getMatiereByParcours ($arrayIdParcours) {
        $arrayParcours = array();
        foreach ($arrayIdParcours as $idParcours) {
            array_push($arrayParcours, $this->getDoctrine()->getRepository(Parcours::class)->find($idParcours));
        }
        $matieresParcours = $this->getDoctrine()->getRepository(MatiereParcours::class)->findMatieresByParcours($arrayParcours);
        $arrayMatiere = array();
        /** @var MatiereParcours $matiereParcours */
        foreach ($matieresParcours as $matiereParcours) {
            array_push($arrayMatiere, $matiereParcours->getMatieres());
        }
        return $arrayParcours;
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
            /** @var array $arrayParcours */
            $arrayParcours = array();
            foreach ($arrayIdParcours as $idParcours) {
                array_push($arrayParcours, $this->getDoctrine()->getRepository(Parcours::class)->find($idParcours));
            }
            $matieresParcours = $this->getDoctrine()->getRepository(MatiereParcours::class)->findMatieresByParcours($arrayParcours);
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
                if(strpos($idMatiere,'-')){
                    $idMatiere = explode(' - ', $idMatiere);
                    $idMatiere = $idMatiere[0];
                    array_push($arrayMatiere, $this->getDoctrine()->getRepository(Matiere::class)->findBy(['code' => $idMatiere]));
                }else{
                    array_push($arrayMatiere, $this->getDoctrine()->getRepository(Matiere::class)->find($idMatiere));
                }

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