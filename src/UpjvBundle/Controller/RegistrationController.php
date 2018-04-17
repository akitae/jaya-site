<?php

namespace UpjvBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\RegisterForm;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

class RegistrationController extends BaseController
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->createUser();

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

            // Vérification que le mot de passe est identique.
            if (strcmp($user->getPassword(), $user->getPlainPassword()) != 0) {
                array_push($errors, "Les mots de passe ne sont pas identiques.");
            }

            if (count($errors) == 0) {
                $tokenGenerator =$this->container->get('fos_user.util.token_generator');
                $user->setConfirmationToken($tokenGenerator->generateToken());

                $userManager->updateUser($user);

                return $this->render('@Upjv/layout.html.twig', [
                    'form' => $form->createView(),
                    'error' => [],
                    'inscription' => "test"
                ]);
            }
        }

        return $this->render('@Upjv/Registration/register.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }


}