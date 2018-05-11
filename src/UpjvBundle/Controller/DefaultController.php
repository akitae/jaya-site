<?php

namespace UpjvBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UpjvBundle\Entity\Utilisateur;

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

        $isAdmin = $this->container->get('security.authorization_checker')->isGranted(Utilisateur::ROLE_SUPER_ADMIN);

        return $this->render('UpjvBundle:Default:index.html.twig', [
            "user" => $user,
            "isAdmin" => $isAdmin
        ]);
    }
}
