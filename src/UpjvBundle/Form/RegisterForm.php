<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 10/03/2018
 * Time: 20:03
 */

namespace UpjvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


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
                'attr' => ['class' => 'form-control '],
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Email'
            ])
            ->add('numeroEtudiant',IntegerType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Numéro étudiant'
            ])
            ->add('motDePasse', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => "Mot de passe"
            ])
            ->add('motDePasseCheck', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Confirmer le mot de passe'
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Enregistrer',
                'attr'  => [
                    'class' => 'btn btn-primary pull-right'
                ]
            ])
        ;
    }
}