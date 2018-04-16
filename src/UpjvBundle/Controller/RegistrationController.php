<?php

namespace UpjvBundle\Controller;

use Monolog\Handler\Curl\Util;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\RegisterForm;

class RegistrationController extends BaseController
{

    public function registerAction(Request $request)
    {
        $user = new Utilisateur();

        $form = $this->createForm(RegisterForm::class, $user);
        $form->handleRequest($request);


        $validator = $this->get("validator");
        $violations = $validator->validate($user);

        $errors = [];
        foreach ($violations as $violation) {
            array_push($errors, $violation->getMessage());
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $user = $form->getData();



            // Vérification de l'identifiant.
            $userBdd = $em->getRepository(Utilisateur::class)->findByUsername($user->getUsername());
            if ($userBdd != null) {
                array_push($errors, "Cet identifiant est déjà utilisé.");
            }

            // Vérification de l'adresse email.
            $userBdd = $em->getRepository(Utilisateur::class)->findUserByEmail($user->getEmail());
            if ($userBdd != null) {
                array_push($errors, "Cette adresse email est déjà utilisée.");
            }

            // Vérification du numéro étudiant.
            $userBdd = $em->getRepository(Utilisateur::class)->findUserByNumeroEtudiant($user->getNumeroEtudiant());
            if ($userBdd != null) {
                array_push($errors, "Le numéro étudiant est déjà existant.");
            }

            if (strcmp($user->getPassword(), $user->getPasswordCheck()) != 0) {
                array_push($errors, "Les mots de passe ne sont pas identiques.");
            }

            if (count($errors) == 0) {


                var_dump($user);
            }





        }

        return $this->render('UpjvBundle:Registration:index.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /*public function indexAction (Request $request) {

        $user = new Utilisateur();
        $error = array();

        $form = $this->createForm(RegisterForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $identifiant = $form->get('identifiant')->getData();
            $user = $em->getRepository('Utilisateur')->findByIdentifiant($identifiant);

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

    }*/

}