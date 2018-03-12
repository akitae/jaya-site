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
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Form\MatiereType;

class MatiereController extends Controller
{
    /**
     * @Route("/admin/matiere", name="admin_matiere")
     * @return mixed
     */
    public function indexAction()
    {
        $listMatiere = $this->getDoctrine()->getRepository(Matiere::class)->findAll();

        return $this->render('UpjvBundle:Admin/Matiere:index.html.twig',[
            'listMatiere' => $listMatiere
        ]);
    }
    
    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/matiere/edit/{id}", name="admin_matiere_edit")
     */
    public function updateAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
 
        $matiere = $em->getRepository(Matiere::class)->find($id);

        if (!$matiere instanceof Matiere) {
            $matiere = new Matiere();
        }

        $form = $this->createForm(MatiereType::class,$matiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $matiere = $form->getData();
                $em->persist($matiere);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'La matière a bien été enregistrée.');
            }catch (\Exception $e){
                $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de l\'enregistrement.');
                return $this->redirectToRoute('admin_matiere_edit',['id' => $id]);
            }

            return $this->redirectToRoute('admin_matiere');
        }

        return $this->render('UpjvBundle:Admin/Matiere:update.html.twig',[
            'matiere' => $matiere,
            'form' => $form->createView()
        ]);
    }
    
    /**
     * @param $id
     * @Route("/admin/matiere/show/{id}", name="admin_matiere_show")
     * @return mixed
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $matiere = $em->getRepository(Matiere::class)->find($id);

        if (!$matiere instanceof Matiere) {
            $this->get('session')->getFlashBag()->add('erreur', 'La matière selectionnée n\'existe pas');
            return $this->redirectToRoute('admin_matiere');
        }

        return $this->render('UpjvBundle:Admin/Matiere:show.html.twig',[
            'matiere' => $matiere
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/matiere/delete/{id}", name="admin_matiere_delete")
     * @return mixed
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        try{
            $matiere = $em->getRepository(Matiere::class)->find($id);
            $em->remove($matiere);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'La matière a bien été supprimée');
        }catch (\Exception $e){
            $this->get('session')->getFlashBag()->add('erreur', 'Une erreur s\'est produite lors de la suppression');
        }
        return $this->redirectToRoute('admin_matiere');
    }
}
