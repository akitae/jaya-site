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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\Utilisateur;

class GroupeType extends AbstractType
{
  /**
  * {@inheritdoc}
  */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add('typeCours',TextType::class,[
      'attr' => ['class' => 'form-control '],
      'label' => 'Type cours'
    ])
    ->add('matiere', EntityType::class,
    [
      'class' => Matiere::class,
      'attr' => [
        'class' => 'form-control select2'
      ]
    ])
    ->add('utilisateurs', EntityType::class,
    [
      'class' => Utilisateur::class,
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
      'data_class' => 'UpjvBundle\Entity\Groupe'
    ));
  }

  /**
  * {@inheritdoc}
  */
  public function getBlockPrefix()
  {
    return 'upjvbundle_groupe';
  }


}
