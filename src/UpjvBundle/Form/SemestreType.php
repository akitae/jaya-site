<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UpjvBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class SemestreType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('nom',TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Nom'
            ])
            
            ->add('dateDebut', TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Début du semestre'
            ])

            ->add('dateFin', TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Fin du semestre'
            ])
            ->add('dateDebutChoix', TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Date et heure de l\'ouverture des choix d\'optionnelles'                    
                
            ])
            ->add('dateFinChoix', TextType::class,[
                'attr' => ['class' => 'form-control '],
                'label' => 'Date et heure de fin des choix d\'optionnelles'

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
            'data_class' => 'UpjvBundle\Entity\Semestre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'upjvbundle_semestre';
    }
}