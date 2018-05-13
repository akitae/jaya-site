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
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\GroupeType;

class GroupeController extends Controller
{
    /**
     * @Route("/admin/groupe", name="admin_groupe")
     * @return mixed
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $listGroupe = $em->getRepository(Groupe::class)->findAll();

        return $this->render('UpjvBundle:Admin/Groupe:index.html.twig',[
            'listGroupe' => $listGroupe
        ]);
    }

    // premiere fonction pour recuperer nom et Matiere puis envoi vers la seconde page
    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/groupe/edit/{id}", name="admin_groupe_edit")
     */
    public function updateAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $groupe = $em->getRepository(Groupe::class)->find($id);

        if (!$groupe instanceof Groupe) {
            $groupe = new Groupe();
        }

        $form = $this->createForm(GroupeType::class,$groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                /** @var Groupe $groupe */
                $groupe = $form->getData();
                $em->persist($groupe);
                $em->flush();

                return $this->redirectToRoute('admin_groupe_edit_2',[
                    'id' => $groupe->getId(),
                ]);

            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de l\'enregistrement.');
                return $this->redirectToRoute('admin_groupe_edit',['id' => $id]);
            }
        }

        return $this->render('UpjvBundle:Admin/Groupe:update.html.twig',[
            'groupe' => $groupe,
            'form' => $form->createView()
        ]);
    }


    // Seconde page qui prends le nom du groupe et la matiere et qui ajoutera les utilisateurs
    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/groupe/edit_2/{id}", name="admin_groupe_edit_2")
     */
    public function updateAction_2($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $groupe = $em->getRepository(Groupe::class)->find($id);
        $matiere = $groupe->getMatiere();

        $listEtudiantSansGroupeForMatiere = $em->getRepository(Utilisateur::class)->findByEtudiantNoGroupeForMatiere($matiere);
        $listEtudiantInThisGroupe = $em->getRepository(Utilisateur::class)->findByRoleAndMatiere($matiere,$groupe);

        if (!$groupe instanceof Groupe) {
            $groupe = new Groupe();
        }

        if ($_POST) {

            if(isset($_POST['notInGroupe'])){
                foreach ($_POST['notInGroupe'] as $idUser){
                    $user = $em->getRepository(Utilisateur::class)->find($idUser);
                    $groupe->removeUtilisateur($user);
                    $em->persist($groupe);
                }
            }

            if(isset($_POST['inGroupe'])){
                foreach ($_POST['inGroupe'] as $idUser){
                    $user = $em->getRepository(Utilisateur::class)->find($idUser);
                    $in = false;
                    foreach ($user->getGroupes() as $groupeUser){
                        if($groupeUser === $groupe){
                            $in = true;
                        }
                    }
                    if(!$in){
                        $groupe->addUtilisateur($user);
                        $em->persist($groupe);
                    }
                }
            }

            $em->flush();

            return $this->redirectToRoute('admin_groupe_show',['id' => $groupe->getId()]);
        }

        return $this->render('UpjvBundle:Admin/Groupe:update_2.html.twig',[
            'groupe' => $groupe,
            'listEtudiant' => $listEtudiantSansGroupeForMatiere,
            'listEtudiantInMatiere' => $listEtudiantInThisGroupe,
            'matiere' => $matiere
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/groupe/show/{id}", name="admin_groupe_show")
     * @return mixed
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $groupe = $em->getRepository(Groupe::class)->find($id);

        if (!$groupe instanceof Groupe) {
            $this->get('session')->getFlashBag()->add('erreur', 'Le groupe selectionné n\'existe pas');
            return $this->redirectToRoute('admin_groupe');
        }

        return $this->render('UpjvBundle:Admin/Groupe:show.html.twig',[
            'groupe' => $groupe
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/groupe/delete/{id}", name="admin_groupe_delete")
     * @return mixed
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        try{
            $groupe = $em->getRepository(Groupe::class)->find($id);
            $em->remove($groupe);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Le groupe a bien été supprimé');
        }catch (\Exception $e){
            $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de la suppression');
        }

        return $this->redirectToRoute('admin_groupe');
    }
}
