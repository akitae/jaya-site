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
use UpjvBundle\Entity\Semestre;
use UpjvBundle\Form\SemestreType;

class SemestreController extends Controller
{
    /**
     * @Route("/admin/semestre", name="admin_semestre")
     * @return mixed
     */
    public function indexAction()
    {
        $listSemestre= $this->getDoctrine()->getRepository(Semestre::class)->findAll();

        return $this->render('UpjvBundle:Admin/Semestre:index.html.twig',[
            'listSemestre' => $listSemestre
        ]);
    }
    
    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/semestre/edit/{id}", name="admin_semestre_edit")
     */
    public function updateAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
 
        $semestre= $em->getRepository(Semestre::class)->find($id);

        if (!$semestre instanceof Semestre) {
            $semestre = new Semestre();
        }

        $form = $this->createForm(SemestreType::class,$semestre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $semestre = $form->getData();
            $em->persist($semestre);
            $em->flush();

            $listSemestre = $this->getDoctrine()->getRepository(Semestre::class)->findAll();
            return $this->render('UpjvBundle:Admin/Semestre:index.html.twig',[
                'updateResponse' => true,
                'listSemestre' => $listSemestre

            ]);
        }

        return $this->render('UpjvBundle:Admin/Semestre:update.html.twig',[
            'semestre' => $semestre,
            'form' => $form->createView()
        ]);
    
    }
    
    /**
     * @param $id
     * @Route("/admin/semestre/show/{id}", name="admin_semestre_show")
     * @return mixed
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $semestre = $em->getRepository(Semestre::class)->find($id);

        if (!$semestre instanceof Semestre) {
            die('error : ce semestre n\'existe pas');
        }

        return $this->render('UpjvBundle:Admin/Semestre:show.html.twig',[
            'semestre' => $semestre
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/semestre/delete/{id}", name="admin_semestre_delete")
     * @return mixed
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $semestre = $em->getRepository(Semestre::class)->find($id);
        $em->remove($semestre);
        $em->flush();

        $listSemestre = $this->getDoctrine()->getRepository(Semestre::class)->findAll();

        return $this->render('UpjvBundle:Admin/Semestre:index.html.twig',[
            'listSemestre' => $listSemestre,
            'deleteResponse' => true
        ]);
    }
}