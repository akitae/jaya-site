<?php
/**
 * Created by PhpStorm.
 * User: Akitae
 * Date: 21/02/2018
 * Time: 09:58
 */

namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\PoleDeCompetence;
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
            $this->repartitionObligatoire();
            $this->repartitionOptionnel($semestre);


            /** Répartition des stagiares */
            $this->repartitionObligatoire(true);

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

            /** @var MatiereOptionelle $choice */
            foreach ($allChoice as $choice){
                $arrayChoice[$choice->getOrdre()] = $choice;
            }

            $ordre = 1;
            while($arrayChoice != null){
                $listMatiereOrderByOrdre = $em->getRepository(Matiere::class)->findDistinctMatiereByPoleAndOrdre($ordre, $poleDeCompetence);

                /** @var Matiere $matiere */
                foreach ($listMatiereOrderByOrdre as $matiere){
                    $listUserForMatiereOptionnel = $em->getRepository(Utilisateur::class)->findListUserForMatiereOptionnel($matiere, $semestre, $ordre);

                    foreach ($listUserForMatiereOptionnel as $user){
                        $arrayListUser[] = $listUserForMatiereOptionnel;
                    }

                    if($em->getRepository(MatiereOptionelle::class)->countNbrOptionEtudiantWant($matiere) <= $matiere->getNbrPlaces($stagiaire)){

                        $this->assignAllStudentForMatiere($matiere);
                    }
                    else{
                        while($matiere->getNbrPlaces($stagiaire)>0 && $arrayListUser != null){
                            $listUserForMatiereOptionnel =  $this->assignChoiceToUser($listUserForMatiereOptionnel);
                        }
                    }
                }
                unset($arrayChoice[$ordre]);
                $ordre++;

            }
        }
    }

    public function assignChoiceToUser($arrayChoiceUser,Matiere $matiere, PoleDeCompetence $poleDeCompetence, $order){
        $array = $arrayChoiceUser[$poleDeCompetence->getId()][$order];
        $nbrRandom = rand(0,count($array));
        $array = array_values($arrayChoiceUser[$poleDeCompetence->getId()][$order]); //on réordonne le tableau
        $user = $arrayChoiceUser[$poleDeCompetence->getId()][$order][$nbrRandom];

        if(! $user instanceof Utilisateur){
            dump("erreur ce n'est pas un user " .$user);die;
        }
        $user->addMatiere($matiere);
        unset($arrayChoiceUser[$poleDeCompetence->getId()][$order][$nbrRandom]);

        if(getMatiereByPole($user) >= getNbrMatiereMustHaveUserByPole()){
            //l'utilisateur a tous ces choix pour le pôle, on lui enlève les autres choix pour le pole
            foreach ($arrayChoiceUser[$poleDeCompetence->getId()] as $order){
                foreach ($order as $userContent){
                    if($userContent instanceof Utilisateur and $userContent===$user){
                        unset($arrayChoiceUser[$poleDeCompetence->getId()][$order][$userContent]);
                    }
                }
            }
        }

        return $arrayChoiceUser;
    }
}
