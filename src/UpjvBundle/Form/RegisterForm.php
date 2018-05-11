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
                'attr' => ['class' => 'form-control '],
                'label' => 'Nom'
            ])
            ->add('prenom',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'label' => 'Prénom'
            ])
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Identifiant'
            ])
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control'],
                'label' => 'Email'
            ])
            ->add('numeroEtudiant',TextType::class,[
                'attr' => ['class' => 'form-control'],
                'label' => 'Numéro étudiant'
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Mot de passe"
            ])
            ->add('plainPassword', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Confirmer le mot de passe'
            ])
            ->add('parcours', EntityType::class, [
                'class' => Parcours::class,
                'attr' => ['class' => 'form-control'],
                'label' => 'Parcours'
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Valider',
                'attr'  => [
                    'class' => 'btn btn-lg btn-block btn-inscription'
                ]
            ])
        ;
    }
}