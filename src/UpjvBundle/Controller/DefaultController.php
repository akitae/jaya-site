<?php

namespace UpjvBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UpjvBundle:Default:index.html.twig');
    }
}
