<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\Semestre;


class MatiereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code',TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Code'
            ])
            ->add('nom',TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Nom'
            ])
            
            ->add('place', IntegerType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Nombre de places'
            ])

            ->add('semestre', EntityType::class,
                [
                    'class' => Semestre::class,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
            ->add('poleDeCompetence', EntityType::class,
                [
                    'class' => PoleDeCompetence::class,
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
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UpjvBundle\Entity\Matiere'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'upjvbundle_matiere';
    }
}