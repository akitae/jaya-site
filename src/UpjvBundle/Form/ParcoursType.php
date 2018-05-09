<?php

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\Semestre;
use UpjvBundle\Repository\MatiereRepository;

class ParcoursType extends AbstractType
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
    ->add('code',TextType::class,[
      'attr' => ['class' => 'form-control '],
      'label' => 'Code'
    ])
    ->add('annee',IntegerType::class,[
      'attr' => ['class' => 'form-control '],
      'label' => 'Annee'
    ])
    ->add('semestres', EntityType::class,
    [
      'class' => Semestre::class,
      'multiple' => true,
      'attr' => [
        'class' => 'form-control select2'
      ]
    ])
    ->add('matieres', EntityType::class,
        [
            'class' => Matiere::class,
            'query_builder' => function(MatiereRepository $er)
            {
                return $er->findAll();
            },
            'multiple' => true,
            'expanded' => true,
            'attr' => [
                'hidden' => 'hidden'
            ]
        ])
    ->add('matiereOptionnelle', EntityType::class,
        [
            'class' => Matiere::class,
            'multiple' => true,
            'expanded' => true
        ])
    /*->add('polesDeCompetence', EntityType::class,
        [
            'class' => PoleDeCompetence::class,
            'multiple' => true,
            'expanded' => true
        ])*/
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
      'data_class' => 'UpjvBundle\Entity\Parcours'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'upjvbundle_ParcoursType';
  }


}
