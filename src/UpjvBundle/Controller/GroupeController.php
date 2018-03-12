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
use UpjvBundle\Form\GroupeType;

class GroupeController extends Controller
{
    /**
     * @Route("/admin/groupe", name="admin_groupe")
     * @return mixed
     */
    public function indexAction()
    {
        $listGroupe = $this->getDoctrine()->getRepository(Groupe::class)->findAll();

        return $this->render('UpjvBundle:Admin/Groupe:index.html.twig',[
            'listGroupe' => $listGroupe
        ]);
    }

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
            $groupe = $form->getData();
            $em->persist($groupe);
            $em->flush();

            $listGroupe = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
            return $this->render('UpjvBundle:Admin/Groupe:index.html.twig',[
                'updateResponse' => true,
                'listGroupe' => $listGroupe

            ]);
        }

        return $this->render('UpjvBundle:Admin/Groupe:update.html.twig',[
            'groupe' => $groupe,
            'form' => $form->createView()
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
            die('error : cette matière n existe pas');
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
        $groupe = $em->getRepository(Groupe::class)->find($id);
        $em->remove($groupe);
        $em->flush();

        $listGroupe = $this->getDoctrine()->getRepository(Groupe::class)->findAll();

        return $this->render('UpjvBundle:Admin/Groupe:index.html.twig',[
            'listGroupe' => $listGroupe,
            'deleteResponse' => true
        ]);
    }
}
