<?php

namespace UpjvBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use UpjvBundle\Entity\Utilisateur;
use UpjvBundle\Form\RegisterForm;
use FOS\UserBundle\Controller\RegistrationController as BaseControllers;

class RegistrationController extends BaseControllers
{

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        // On crée un utilisateur avec le manager.
        $userManager = $this->get('fos_user.user_manager');
        /** @var Utilisateur $user */
        $user = $userManager->createUser();

        // On crée le formulaire d'inscription.
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
                // On met le nom en majuscule.
                $user->setNom(strtoupper($user->getNom()));
                $user->addRole(Utilisateur::ROLE_ETUDIANT);

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

        }

        return $this->render('@Upjv/Registration/register.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors
        ]);
    }

    /**
     * @param Request $request
     * @param string $token
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function confirmAction(Request $request, $token)
    {
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');

        $user = $userManager->findUserByConfirmationToken($token);

        if (null === $user) {
            throw new NotFoundHttpException(sprintf('The user with confirmation token "%s" does not exist', $token));
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user->setConfirmationToken(null);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_CONFIRM, $event);

        $userManager->updateUser($user);

        if (null === $response = $event->getResponse()) {
            $url = $this->generateUrl('fos_user_registration_confirmed');
            $response = new RedirectResponse($url);
        }

        return $response;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function confirmedAction()
    {
        return $this->render('@FOSUser/Registration/confirmed.html.twig');
    }

}