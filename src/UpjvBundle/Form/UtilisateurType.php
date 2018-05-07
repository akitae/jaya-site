<?php

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\Parcours;

class UtilisateurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
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
            ->add('numeroEtudiant',TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Numéro étudiant'
            ])
            ->add('username', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Identifiant'
            ])
            ->add('parcours', EntityType::class,
                [
                    'class' => Parcours::class,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
            ->add('save', SubmitType::class,[
                'label' => 'Enregistrer',
                'attr'  => [
                    'class' => 'btn btn-primary pull-right'
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UpjvBundle\Entity\Utilisateur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'upjvbundle_utilisateur';
    }


}
