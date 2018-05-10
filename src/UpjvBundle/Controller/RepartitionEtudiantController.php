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
            $this->repartitionObligatoire();


            /** Répartition des stagiares */
            $this->repartitionObligatoire(true);
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
                ->findListUserByMatiere($matiere);

            /** @var Utilisateur $user */
            foreach ($listUserByMatiere as $user){
                if($matiere->getNbrPlaces() > 0){
                    $user->addMatiere($matiere);
                    $em->persist($user);
                $matiere->setNbrPlaces($matiere->getNbrPlaces()-1);
                }else{
                    die("Le nombre d'étudiant ayant la maitère obligatoire est supérieure aux nombres de places disponible, matière :".$matiere->getNom());
                }
            }
        }
        $em->flush();
    }


}
