<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 10/03/2018
 * Time: 09:00
 */

namespace UpjvBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\UtilisateurType;

class RegistrationController extends Controller
{

    /**
     * @Route("/registration", name="registration")
     * @return mixed
     */
    public function indexAction (Request $request) {

        $user = new Utilisateur();

        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('upjv_connection_index');
        }

        return $this->render('UpjvBundle:Registration:index.html.twig', [
            'form' => $form->createView()
        ]);

    }

}