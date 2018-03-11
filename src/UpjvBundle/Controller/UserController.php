<?php
/**
 * Created by PhpStorm.
 * User: Akitae
 * Date: 21/02/2018
 * Time: 09:58
 */

namespace UpjvBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\UtilisateurType;

class UserController extends Controller
{
    /**
     * @Route("/admin/user", name="admin_user")
     * @return mixed
     */
    public function indexAction()
    {
        $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();

        return $this->render('UpjvBundle:Admin/User:index.html.twig',[
            'listUser' => $listUser
        ]);
    }

    /**
     * @param $id
     * @param $request
     * @return mixed
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     */
    public function updateAction($id,Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        /** @var Utilisateur $user */
        $user = $em->getRepository(Utilisateur::class)->find($id);

        if (!$user instanceof Utilisateur) {
            $user = new Utilisateur();
        }

        $form = $this->createForm(UtilisateurType::class,$user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try{
                $user = $form->getData();
                $em->persist($user);
                $em->flush();
                $update = true;
            }catch (\Exception $e){
                $update = false;
            }


            $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
            return $this->render('UpjvBundle:Admin/User:index.html.twig',[
                'updateResponse' => $update,
                'listUser' => $listUser

            ]);
        }

        return $this->render('UpjvBundle:Admin/User:update.html.twig',[
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/user/show/{id}", name="admin_user_show")
     * @return mixed
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->find($id);

        if (!$user instanceof Utilisateur) {
            die('error : cette utilistateur n existe pas');
        }

        return $this->render('UpjvBundle:Admin/User:show.html.twig',[
            'user' => $user
        ]);
    }

    /**
     * @param $id
     * @Route("/admin/user/delete/{id}", name="admin_user_delete")
     * @return mixed
     */
    public function deleteAction($id){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->find($id);
        $em->remove($user);
        $em->flush();

        $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();

        return $this->render('UpjvBundle:Admin/User:index.html.twig',[
            'listUser' => $listUser,
            'deleteResponse' => true
        ]);
    }
}