<?php
/**
 * Created by PhpStorm.
 * User: Akitae
 * Date: 21/02/2018
 * Time: 09:58
 */

namespace UpjvBundle\Controller;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\PoleDeCompetenceParcours;
use UpjvBundle\Entity\Semestre;
use UpjvBundle\Entity\Utilisateur;

class RepartitionEtudiantController extends Controller
{
    /**
     * @Route("/admin/repartitionEtudiant", name="admin_repartition_etudiant")
     * @return mixed
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $listSemestre = $em->getRepository(Semestre::class)->findAll();

        $em->getRepository(Groupe::class)->resetAllGroupe();

        if(!empty($_POST['repartition'])){
            $semestre = $em->getRepository(Semestre::class)->find($_POST['repartition']);
            $em->getRepository(Matiere::class)->resetMatiereUtilisateur($semestre);

            $this->reinitialiseMatiere();
            $this->repartitionObligatoire($semestre);
            $this->repartitionOptionnel($semestre);

            /** Répartition des stagiares */
            $this->repartitionObligatoire($semestre,true);
            $this->repartitionOptionnel($semestre,true);

            $this->get('session')->getFlashBag()->add('success', 'Répartition exécuter, en cas d\'erreur, veuillez ajuster le nombre de place par parcours. Rendez-vous sur la page 
            Trie des étudiants' );

        }

        return $this->render('UpjvBundle:Admin/RepartitionEtudiant:index.html.twig',[
            'listSemestre' => $listSemestre
        ]);

    }

    /**
     * @param bool $stagiare
     */
    public function repartitionObligatoire($semestre, $stagiare = false){
        $em= $this->getDoctrine()->getManager();
        $allMatieres = $em->getRepository(Matiere::class)->findAllToArray();

        /** @var Matiere $matiere */
        foreach ($allMatieres as $matiere){
            $listUserByMatiere = $em->getRepository(Utilisateur::class)->findListUserByMatiere($matiere,$semestre,false, $stagiare);

            /** @var Utilisateur $user */
            foreach ($listUserByMatiere as $user){
                if($matiere->getNbrPlaces($stagiare) > 0){
                    $user->addMatiere($matiere);
                    $em->persist($user);
                    $matiere->setNbrPlaces($matiere->getNbrPlaces($stagiare)-1,$stagiare);
                    $em->persist($matiere);
                }else{
                    $Isstagiare = $stagiare==true ?'oui':'non';
                    $this->get('session')->getFlashBag()->add('erreur',
                        "Le nombre d'étudiant ayant la maitère obligatoire est supérieure aux nombres de places disponible, matière $matiere
                         Concerne les stagaires : $Isstagiare
                        Verifier le nombre de place pour les matières");
                    return $this->redirectToRoute('admin_repartition_etudiant');
                }
            }
        }
        $em->flush();
    }

    public function repartitionOptionnel($semestre, $stagiaire = false){
        $em= $this->getDoctrine()->getManager();
        $allPole = $em->getRepository(PoleDeCompetence::class)->findAll();

        foreach ($allPole as $poleDeCompetence){
            $ordre = 1;
            $ordreMax = $em->getRepository(MatiereOptionelle::class)->getNumberOrdreMaxForPoleDeCompetence($poleDeCompetence);

            while($ordre<=$ordreMax){
                $listMatiereOrderByOrdre = $em->getRepository(Matiere::class)->findDistinctMatiereByPoleAndOrdre($ordre, $poleDeCompetence);

                $arrayChoice = [];
                /** @var Matiere $matiere */
                foreach ($listMatiereOrderByOrdre as $matiere){
                    $tmp = $em->getRepository(Utilisateur::class)->findListUserForMatiereOptionnel($matiere, $semestre, $ordre, $stagiaire);
                    for($i=0; $i<count($tmp);$i++){
                        $arrayChoice[$matiere->getId()][] = $tmp[$i];
                    }
                }

                /** @var Matiere $matiere */
                foreach ($listMatiereOrderByOrdre as $matiere){
                    if(isset($arrayChoice[$matiere->getId()])){
                        $arrayChoice = $this->deleteUserIfHaveMatiereByPole($arrayChoice,$poleDeCompetence);

                        $nbrEtudiant = intval($em->getRepository(MatiereOptionelle::class)->countNbrOptionEtudiantWant($matiere));
                        if($nbrEtudiant <= $matiere->getNbrPlaces($stagiaire)){

                            $this->assignAllStudentForMatiere($arrayChoice[$matiere->getId()],$matiere,$poleDeCompetence,$ordre);
                            $matiere->setNbrPlaces($matiere->getNbrPlaces($stagiaire)-$nbrEtudiant,$stagiaire);
                            unset($arrayChoice[$matiere->getId()]);
                        }
                        else{
                            while($matiere->getNbrPlaces($stagiaire)>0 && !empty($arrayChoice[$matiere->getId()])){
                                $arrayChoice[$matiere->getId()] =  $this->assignChoiceToUser($arrayChoice[$matiere->getId()],$matiere, $poleDeCompetence,$ordre);
                                $matiere->setNbrPlaces($matiere->getNbrPlaces($stagiaire)-1,$stagiaire);
                            }
                            unset($arrayChoice[$matiere->getId()]);
                        }
                    }
                }
                $em->flush();
                $ordre++;
            }
        }
    }

    public function assignChoiceToUser($arrayChoiceUser,Matiere $matiere, PoleDeCompetence $poleDeCompetence,$ordre){
        $em = $this->getDoctrine()->getManager();
        $nbrRandom = rand(0,count($arrayChoiceUser)-1);
        $arrayChoiceUser = array_values($arrayChoiceUser); //on réordonne le tableau
        $user = $arrayChoiceUser[$nbrRandom];

        if(! $user instanceof Utilisateur){
            dump("erreur ce n'est pas un user ",$user);die;
        }
        $user->addMatiere($matiere);
        unset($arrayChoiceUser[$nbrRandom]);

        return $arrayChoiceUser;
    }

    public function assignAllStudentForMatiere($arrayListUser,Matiere $matiere,PoleDeCompetence $poleDeCompetence, $ordre){
        /** @var Utilisateur $user */
        foreach ($arrayListUser as $user){
            $user->addMatiere($matiere);
            $this->getDoctrine()->getManager()->persist($user);
        }
        return $arrayListUser;

    }

    public function deleteUserIfHaveMatiereByPole($array, PoleDeCompetence $poleDeCompetence)
    {
        $em = $this->getDoctrine()->getManager();

        $listUser = $em->getRepository(Utilisateur::class)->getUniqueListUserOptionnelByPole($poleDeCompetence);

        /** @var Utilisateur $user */
        foreach ($listUser as $user) {
            if ($em->getRepository(Matiere::class)->getNbrMatiereOptionnelByPole($user,$poleDeCompetence,true) >=
                $em->getRepository(PoleDeCompetenceParcours::class)->getNbrMatiereOptionnelMustHaveUserByPole($user, $poleDeCompetence)) {
                foreach ($array as $nomMatiere => $matiere) {
                    foreach ($matiere as $key => $userContent) {
                        if ($user === $userContent) {
                            unset($array[$nomMatiere][$key]);
                        }
                    }
                }
            }
        }
        return $array;
    }

    public function reinitialiseMatiere(){

        $allMatieres = $this->getDoctrine()->getManager()->getRepository(Matiere::class)->findAllToArray();

        foreach ($allMatieres as $matiere){
            $matiere->setNbrPlaces($matiere->getNbrPlaceMax());
            $matiere->setPlaceStagiare($matiere->getNbrPlaceStagiareMax());
            $this->getDoctrine()->getManager()->persist($matiere);
        }
        $this->getDoctrine()->getManager()->flush();
    }
}
