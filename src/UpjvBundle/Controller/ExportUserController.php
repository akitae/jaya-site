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
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\Utilisateur;

class ExportUserController extends Controller
{
    /**
     * @Route("/admin/listUser", name="admin_export_user")
     * @return mixed
     */
    public function indexAction()
    {
        $listUser = $this->getDoctrine()->getRepository(Utilisateur::class)->findBy(['type' => Utilisateur::TYPE_ETUDIANT]);

        $listGroup = $this->getDoctrine()->getRepository(Groupe::class)->findAll();
        $listParcours = $this->getDoctrine()->getRepository(Parcours::class)->findAll();

        return $this->render('UpjvBundle:Admin/ExportUser:index.html.twig',[
            'listUser' => $listUser,
            'listGroup' => $listGroup,
            'listParcours' => $listParcours
        ]);
    }
}