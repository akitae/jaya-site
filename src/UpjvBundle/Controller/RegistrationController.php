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
use UpjvBundle\Form\RegisterForm;

class RegistrationController extends Controller
{

    /**
     * @Route("/registration", name="registration")
     * @return mixed
     */
    public function indexAction (Request $request) {

        $user = new Utilisateur();
        $error = array();

        $form = $this->createForm(RegisterForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $email = $form->get('email')->getData();
            $user = $em->getRepository('UpjvBundle:Utilisateur')->findUserByEmail($email);

            if ($user != null) array_push($error, "Email existant");

            $numero = $form->get('numeroEtudiant')->getData();
            $user = $em->getRepository('UpjvBundle:Utilisateur')->findUserByNumero($numero);

            if ($user != null) array_push($error, "Numéro étudiant existant");

            $password = $form->get('motDePasse')->getData();
            $passwordCheck = $form->get('motDePasseCheck')->getData();

            if ($password != $passwordCheck) array_push($error, "Les mots de passe ne sont pas identique.");

            if (empty($error)) {
                $user = new Utilisateur();
                $user->setNom(strtoupper($form->get('nom')->getData()));
                $user->setPrenom($form->get('prenom')->getData());
                $user->setEmail($form->get('email')->getData());
                $user->setNumeroEtudiant($form->get('numeroEtudiant')->getData());
                $user->setMotDePasse($form->get('motDePasse')->getData());
                $user->setValide(false);
                $user->setType(0);

                $em->persist($user);
                $em->flush();

                return $this->redirectToRoute('login');
            }
        }

        return $this->render('UpjvBundle:Registration:index.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);

    }

}