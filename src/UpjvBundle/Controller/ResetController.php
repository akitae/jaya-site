<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Semestre;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\PoleDeCompetenceParcours;
use UpjvBundle\Entity\MatiereParcours;


class ResetController extends Controller
{

  /**
  * @Route("/admin/reset", name="admin_reset")
  * @return mixed
  */
  public function indexAction()
  {
    return $this->render('UpjvBundle:Admin/Reset:index.html.twig');
  }
  
  /**
  * @Route("/admin/reset/resetData", name="admin_reset_data")
  * @return mixed
  */
  public function resetData()
  {
    $em = $this->getDoctrine()->getManager();

     if (!empty($_POST)) {
         try{
            if(isset($_POST['semestre']))
            {
                $allSemestre = $em->getRepository(Semestre::class)->findAll();
                /** @var Semestre $semestre */
                foreach ($allSemestre as $semestre){
                    $em->remove($semestre);
                    /** @var Matiere $matiere */
                    foreach ($semestre->getMatieres() as $matiere){
                        $matiere->setSemestre(null);
                    }
                }
                $em->flush();
            }
            if(isset($_POST['groupe']))
            {
                $em->getRepository(Groupe::class)->resetAllGroupe();             
            }
            if(isset($_POST['option']))
            {
                $em->getRepository(MatiereOptionelle::class)->resetAllMatiereOption();
                $em->getRepository(Matiere::class)->resetAllMatiereUtilisateur();

            }
            
            if(isset($_POST['pole']))
            {
                $em->getRepository(Matiere::class)->resetAllPole();
                $em->getRepository(PoleDeCompetenceParcours::class)->resetAllPoledeCompetenceParcours();
                $em->getRepository(PoleDeCompetence::class)->resetAllPole();

            }
            if(isset($_POST['parcours']))
            {
                $allParcours = $em->getRepository(Parcours::class)->findAll();
                /** @var Parcours $allParcour */
                foreach ($allParcours as $allParcour){
                    /** @var Utilisateur $user */
                    foreach ($allParcour->getUtilisateur() as $user){
                        $user->setParcours(null);
                    }
                    $em->persist($user);
                    $em->flush();
                }
                $em->getRepository(PoleDeCompetenceParcours::class)->resetAllPoledeCompetenceParcours();
                $em->getRepository(Parcours::class)->resetAllParcours();
            }
            if(isset($_POST['matiereParcours']))
            {                  
                $em->getRepository(MatiereParcours::class)->resetAllMatiereParcours();
            }
            if(isset($_POST['matiere']))
            {
                $em->getRepository(Matiere::class)->resetAllMatiere();
            }
            if(isset($_POST['etudiant']))
            {
                $em->getRepository(Utilisateur::class)->resetByRole(Utilisateur::ROLE_ETUDIANT , Utilisateur::ROLE_PROFESSEUR, Utilisateur::ROLE_ADMIN, Utilisateur::ROLE_SUPER_ADMIN);
            }
                 
             
             $em->flush();
             $this->get('session')->getFlashBag()->add('success', 'Les éléments sélectionnés ont été supprimés.');


             }catch (\Exception $e){
                 $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de la suppression. '.$e->getMessage());
                  return $this->redirectToRoute('admin_reset');
             }


         }

         return $this->redirectToRoute('admin_reset');
         
    
  }
          
       
}

