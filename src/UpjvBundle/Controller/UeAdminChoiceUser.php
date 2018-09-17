<?php
/**
 * Created by PhpStorm.
 * User: akitae
 * Date: 17/09/18
 * Time: 22:25
 */

namespace UpjvBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\MatiereOptionelle;
use UpjvBundle\Entity\Utilisateur;

class UeAdminChoiceUser extends Controller
{

    /**
     * @Route("/admin/choiseUser/{id}", name="admin_choice_user")
     * @return mixed
     */
    public function indexAction(Utilisateur $user){

        $listMatiere = $this->getDoctrine()->getRepository(MatiereOptionelle::class)->findByUserOrderByOrdreAndPole($user);

        return $this->render('UpjvBundle:Admin/UEChoice:show.html.twig',[
            'listMatiere' => $listMatiere
        ]);
    }
}