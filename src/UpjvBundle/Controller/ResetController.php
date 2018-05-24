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

             foreach ($_POST as $name => $value){
                 if($name == 'matiere')
                     $resetMatiere = true;
                 else
                     $resetMatiere = false;
                 if($name == 'groupe')
                     $resetGroupe = true;
                 else
                     $resetGroupe = false;
                 if($name == 'option')
                     $resetOption = true;
                 else
                     $resetOption = false;
                 if($name == 'etudiant')
                     $resetEtudiant = true;
                 else
                     $resetEtudiant = false;
                 if($name == 'pole')
                     $resetPole = true;
                 else
                     $resetPole = false;
                 if($name == 'parcours')
                     $resetParcours = true;
                 else
                     $resetParcours = false;
                 if($name == 'matiereParcours')
                     $resetMatiereParcours = true;
                 else
                     $resetMatiereParcours = false;
                 if($name == 'semestre')
                     $resetSemestre = true;
                 else
                     $resetSemestre = false;
             }
            if($resetSemestre == true)
            {
                $em->getRepository(Parcours::class)->resetAllSemestre();
                $em->getRepository(Matiere::class)->resetAllSemestre();
                $em->getRepository(Semestre::class)->resetAllSemestre();

            }
            if($resetGroupe == true)
            {
                $em->getRepository(Groupe::class)->resetAllGroupe();             
            }
            if($resetOption == true)
            {
                $em->getRepository(MatiereOptionelle::class)->resetAllMatiereOption();
                $em->getRepository(Matiere::class)->resetAllMatiereUtilisateur();

            }
            
            if($resetPole == true)
            {
                $em->getRepository(Matiere::class)->resetAllPole();
                $em->getRepository(PoleDeCompetenceParcours::class)->resetAllPoledeCompetenceParcours();
                $em->getRepository(PoleDeCompetence::class)->resetAllPole();

            }
            if($resetParcours == true)
            {
                $em->getRepository(PoleDeCompetenceParcours::class)->resetAllPoledeCompetenceParcours();
                $em->getRepository(Parcours::class)->resetAllParcours();
            }
            if($resetMatiereParcours == true)
            {                  
                $em->getRepository(MatiereParcours::class)->resetAllMatiereParcours();
            }
            if($resetMatiere == true)
            {
                $em->getRepository(Matiere::class)->resetAllMatiere();
            }
            if($resetEtudiant == true)
            {
                $em->getRepository(Utilisateur::class)->resetByRole(Utilisateur::ROLE_ETUDIANT , Utilisateur::ROLE_PROFESSEUR, Utilisateur::ROLE_ADMIN);
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

