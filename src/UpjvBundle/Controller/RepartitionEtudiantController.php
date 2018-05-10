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

        if(!empty($_POST['repartition'])){
            $em->getRepository(Matiere::class)->resetMatiereUtilisateur();
            $semestre = $em->getRepository(Semestre::class)->find($_POST['repartition']);

            //TODO: faire pour le semestre choisi aussi pour obligatoire!
//            $this->repartitionObligatoire();
            $this->repartitionOptionnel($semestre);


            /** Répartition des stagiares */
//            $this->repartitionObligatoire(true);

            if($PasDerror = true){ //todo: ne pas flush en cas d'erreur
                $em->flush();
            }

        }

        return $this->render('UpjvBundle:Admin/RepartitionEtudiant:index.html.twig',[
            'listSemestre' => $listSemestre
        ]);

    }

    /**
     * @param bool $stagiare
     */
    public function repartitionObligatoire($stagiare = false){
        $em= $this->getDoctrine()->getManager();
        $allMatieres = $em->getRepository(Matiere::class)->findAllToArray();

        /** @var Matiere $matiere */
        foreach ($allMatieres as $matiere){
            $listUserByMatiere = $em->getRepository(Utilisateur::class)
                ->findListUserByMatiere($matiere,false, $stagiare);

            /** @var Utilisateur $user */
            foreach ($listUserByMatiere as $user){
                if($matiere->getNbrPlaces($stagiare) > 0){
                    $user->addMatiere($matiere);
                    $em->persist($user);
                $matiere->setNbrPlaces($matiere->getNbrPlaces($stagiare)-1,$stagiare);
                }else{
                    $Isstagiare = $stagiare==true ?'oui':'non';
                    dump("Le nombre d'étudiant ayant la maitère obligatoire est supérieure aux nombres de places disponible, matière :".$matiere->getNom()
                    .' Concerne les stagaires : '.$Isstagiare);die;
                }
            }
        }
    }

    public function repartitionOptionnel($semestre, $stagiaire = false){
        $em= $this->getDoctrine()->getManager();
        $allPole = $em->getRepository(PoleDeCompetence::class)->findAll();

        foreach ($allPole as $poleDeCompetence){

            $allChoice = $em->getRepository(MatiereOptionelle::class)->findBySemestre($semestre);

//            /** @var MatiereOptionelle $choice */
//            foreach ($allChoice as $choice){
//                $arrayChoice[$choice->getOrdre()] = $choice;
//            }


            $ordre = 1;
            $arrayChoice[$ordre] = 'debut';

            while($arrayChoice[$ordre] != null){
                $listMatiereOrderByOrdre = $em->getRepository(Matiere::class)->findDistinctMatiereByPoleAndOrdre($ordre, $poleDeCompetence);

                /** @var Matiere $matiere */
                foreach ($listMatiereOrderByOrdre as $matiere){
                    $listUserForMatiereOptionnel = $em->getRepository(Utilisateur::class)->findListUserForMatiereOptionnel($matiere, $semestre, $ordre);

//                    dump($listUserForMatiereOptionnel);die;
                    $arrayChoice[$ordre] = [];
                    for($i=0; $i<count($listUserForMatiereOptionnel);$i++){
                        $arrayChoice[$ordre][] = $listUserForMatiereOptionnel[$i];
                    }

                    if(intval($em->getRepository(MatiereOptionelle::class)->countNbrOptionEtudiantWant($matiere)) <= $matiere->getNbrPlaces($stagiaire)){
                        $this->assignAllStudentForMatiere($arrayChoice,$matiere,$ordre);
//                        TODO: delete a choice
                    }
                    else{
                        while($matiere->getNbrPlaces($stagiaire)>0 && !empty($arrayChoice[$ordre])){
                            $arrayChoice =  $this->assignChoiceToUser($arrayChoice,$matiere, $poleDeCompetence,$ordre);
                        }
                    }
                }

                if(empty($arrayChoice[$ordre])) {
                    unset($arrayChoice[$ordre]);
                    $ordre++;
                }
            }
        }

        $em->flush();
    }

    public function assignChoiceToUser($arrayChoiceUser,Matiere $matiere, PoleDeCompetence $poleDeCompetence,$ordre){
        $em = $this->getDoctrine()->getManager();
        $nbrRandom = rand(0,count($arrayChoiceUser[$ordre])-1);
        $arrayChoiceUser[$ordre] = array_values($arrayChoiceUser[$ordre]); //on réordonne le tableau
        $user = $arrayChoiceUser[$ordre][$nbrRandom];

        if(! $user instanceof Utilisateur){
            dump("erreur ce n'est pas un user ",$user);die;
        }
        $user->addMatiere($matiere);
        unset($arrayChoiceUser[$ordre][$nbrRandom]);

        if($user->getNbrMatiereOptionnelByPole($poleDeCompetence) >= $em->getRepository(PoleDeCompetenceParcours::class)->getNbrMatiereOptionnelMustHaveUserByPole($user,$poleDeCompetence)){
        //l'utilisateur a tous ces choix pour le pôle, on lui enlève les autres choix pour le pole
        foreach ($arrayChoiceUser[$ordre] as $userContent){
                if($userContent instanceof Utilisateur and $userContent===$user){
                    unset($arrayChoiceUser[$ordre][$userContent]);
                }
            }
        }

        return $arrayChoiceUser;
    }

    public function assignAllStudentForMatiere($arrayListUser,Matiere $matiere,$ordre){
        /** @var Utilisateur $user */
        foreach ($arrayListUser[$ordre] as $user){
            $user->addMatiere($matiere);
            $this->getDoctrine()->getManager()->persist($user);
        }

    }
}
