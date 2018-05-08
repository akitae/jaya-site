<?php

namespace UpjvBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     *  @Route("/", name="upjv_homepage")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {

    }
}
