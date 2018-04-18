<?php

namespace UpjvBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
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

        $dispatcher = $this->get('event_dispatcher');

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
                $user->setNom(strtoupper($user->getNom()));
                //$tokenGenerator =$this->container->get('fos_user.util.token_generator');
                //$user->setConfirmationToken($tokenGenerator->generateToken());


                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $this->get('session')->getFlashBag()->clear();
                $this->get('session')->getFlashBag()->add('inscription', 'Votre compte a été crée avec succès. Veuillez attendre sa validation par l\'administration.');
                $this->get('session')->getFlashBag()->add('inscription', 'Consultez votre boîte de messagerie pour valider votre adresse email.');

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

        }

        return $this->render('@Upjv/Registration/register.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }


}