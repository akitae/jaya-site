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
use UpjvBundle\Entity\Utilisateur;

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
     * @Route("/admin/user/edit/{id}", name="admin_user_edit")
     * @return mixed
     */
    public function updateAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Utilisateur::class)->find($id);

        if (!$user instanceof Utilisateur) {
            $user = new Utilisateur();
        }

        return $this->render('UpjvBundle:Admin/User:update.html.twig',[
            'user' => $user
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
}