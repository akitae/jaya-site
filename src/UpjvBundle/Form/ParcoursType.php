<?php

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\Parcours;
use UpjvBundle\Entity\PoleDeCompetence;
use UpjvBundle\Entity\Semestre;

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
    ->add('annee',TextType::class,[
      'attr' => ['class' => 'form-control '],
      'label' => 'Annee'
    ])
    ->add('polesDeCompetences', EntityType::class,
    [
      'class' => PoleDeCompetence::class,
      'multiple' => true,
      'attr' => [
        'class' => 'form-control select2'
      ]
    ])
    ->add('semestres', EntityType::class,
    [
      'class' => Semestre::class,
      'multiple' => true,
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
