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
use UpjvBundle\Entity\MatiereOptionelle;

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
                 if($name == 'semestre')
                 {
                     $em->getRepository(Matiere::class)->resetAllSemestre();
                     $em->getRepository(Semestre::class)->resetAllSemestre();
                 }
                 if($name == 'groupe')
                 {
                     $em->getRepository(Groupe::class)->resetAllGroupe();             
                 }
                 if($name == 'option')
                 {
                     $em->getRepository(Matiere::class)->resetAllMatiereUtilisateur();
                     $em->getRepository(MatiereOptionelle::class)->resetAllMatiereOption();
                 }
                 if($name == 'etudiant')
                 {
                     $em->getRepository(Utilisateur::class)->resetByRole(Utilisateur::ROLE_ETUDIANT , Utilisateur::ROLE_PROFESSEUR, Utilisateur::ROLE_ADMIN);
                 }

                 
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

