<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 08/03/2018
 * Time: 15:00
 */

namespace UpjvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class LoginForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Login'
            ])
            ->add('_password', PasswordType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Mot de passe'
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Connexion',
                'attr' => [
                    'class' => 'btn btn-primary large-button'
                ]
            ]);
    }

}