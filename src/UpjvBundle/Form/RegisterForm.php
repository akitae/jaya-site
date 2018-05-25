<?php

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Repository\ParcoursRepository;

/**
 * Formulaire d'inscription.
 * @package UpjvBundle\Form
 */
class RegisterForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,[
                'attr' => ['class' => 'form-control input-login'],
                'label' => 'Nom'
            ])
            ->add('prenom',TextType::class,[
                'attr' => ['class' => 'form-control input-login'],
                'label' => 'Prénom'
            ])
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control input-login'],
                'label' => 'Identifiant'
            ])
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control input-login'],
                'label' => 'Email'
            ])
            ->add('numeroEtudiant',TextType::class,[
                'attr' => ['class' => 'form-control input-login'],
                'label' => 'Numéro étudiant'
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control input-login'],
                'label' => "Mot de passe"
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => ['class' => 'form-control input-login'],
                'label' => 'Confirmer le mot de passe'
            ])
            ->add('parcours', EntityType::class, [
                'class' => Parcours::class,
                'query_builder' => function (ParcoursRepository $repo) {
                    return $repo->createQueryBuilder('e')->where('e.stagiare = false');
                },
                'attr' => ['class' => 'form-control js-example-basic-single input-login'],
                'label' => 'Parcours'
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Valider',
                'attr'  => [
                    'class' => 'btn btn-lg btn-block btn-blue'
                ]
            ])
        ;
    }
}