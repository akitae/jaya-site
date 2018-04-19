<?php

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\Groupe;

class ProfesseurType extends AbstractType
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
            ->add('valide', CheckboxType::class,[
                'required' => false,
                'label' => 'Enregistrement validé ?'
            ])
            ->add('groupes', EntityType::class,
                [
                    'class' => Groupe::class,
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control select2'
                    ]
                ])
            ->add('save', SubmitType::class,[
                'label' => 'Enregistrer',
                'attr'  => [
                    'class' => 'btn btn-primary pull-right'
                ]
            ])
        ;
    }/**
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