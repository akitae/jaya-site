<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpjvBundle\Controller;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\DTO\SemestreWrapper;
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

        $semestreWrapper = new SemestreWrapper();
        $semestreWrapper->setId($semestre->getId());
        $semestreWrapper->setNom($semestre->getNom());
        $semestreWrapper->setDateDebut($semestre->getDateDebut()->format('d/m/Y H:i'));
        $semestreWrapper->setDateFin($semestre->getDateFin()->format('d/m/Y H:i'));
        $semestreWrapper->setDateDebutChoix($semestre->getDateDebutChoix()->format('d/m/Y H:i'));
        $semestreWrapper->setDateFinChoix($semestre->getDateFinChoix()->format('d/m/Y H:i'));

        $form = $this->createForm(SemestreType::class,$semestreWrapper);
        $form->handleRequest($request);

//        if(!empty($form->getData()['dateDebut'])){
//            $form->getData()['dateDebut'] = date_create_from_format('Y-m-d H:i:s',$form->getData()['dateDebut']);
//        }
//        dump($form->getData());die;
        if ($form->isSubmitted() && $form->isValid()) {

            $temp = $form->getData();
            $semestre = new Semestre();
            
            $semestre->setId($id);

            $semestre->setNom($temp->getNom());
            $dateDebut = DateTime::createFromFormat('d/m/Y H:i', $temp->getDateDebut());
            $semestre->setDateDebut($dateDebut);

            $dateFin = DateTime::createFromFormat('d/m/Y H:i', $temp->getDateFin());
            $semestre->setDateFin($dateFin);

            $dateDebutChoix = DateTime::createFromFormat('d/m/Y H:i', $temp->getDateDebutChoix());
            $semestre->setDateDebutChoix($dateDebutChoix);

            $dateFinChoix = DateTime::createFromFormat('d/m/Y H:i', $temp->getDateDebutChoix());
            $semestre->setDateFinChoix($dateFinChoix);

            $em->persist($semestre);
            $em->flush();

            $listSemestre = $this->getDoctrine()->getRepository(Semestre::class)->findAll();
            return $this->render('UpjvBundle:Admin/Semestre:index.html.twig',[
                'updateResponse' => true,
                'listSemestre' => $listSemestre

            ]);
        }

        return $this->render('UpjvBundle:Admin/Semestre:update.html.twig',[
            'semestre' => $semestreWrapper,
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