<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 04/03/2018
 * Time: 21:50
 */

namespace UpjvBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UpjvBundle\Form\LoginForm;

class LoginController extends Controller
{

    /**
     * @Route("/connexion", name="connexion")
     * @return mixed
     */
    public function loginAction (Request $request) {

        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('UpjvBundle:Login:index.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);
    }

}