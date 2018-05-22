<?php

namespace UpjvBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UpjvBundle\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Parcours;

class DefaultController extends Controller
{
  /**
  *  @Route("/", name="upjv_homepage")
  * @return \Symfony\Component\HttpFoundation\Response
  */
  public function indexAction()
  {
    /** @var Utilisateur $user */
    $user = $this->getUser();

    if (!is_object($user) || !$user instanceof UserInterface) {
      throw new AccessDeniedException('This user does not have access to this section.');
    }

    $isAdmin = $this->container->get('security.authorization_checker')->isGranted(Utilisateur::ROLE_ADMIN);

    return $this->render('UpjvBundle:Default:index.html.twig', [
      "user" => $user,
      "isAdmin" => $isAdmin
    ]);
  }

  /**
  *  @Route("/admin", name="admin")
  * @return mixed
  */
  public function dashboardAction()
  {
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository(Utilisateur::class)->findByValidate();
    $listGroup = $em->getRepository(Groupe::class)->findAll();
    $listMatieres = $this->getDoctrine()->getRepository(Matiere::class)->findAllToArray();

    return $this->render('UpjvBundle:Admin/Dashboard:dashboard.html.twig', [
      "user_list" => $user,
      'listGroup' => $listGroup,
      'listMatieres' => $listMatieres
    ]);
  }



}
