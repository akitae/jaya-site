<?php

namespace UpjvBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
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
    ->add('nom',TextType::class,[
      'attr' => ['class' => 'form-control '],
      'label' => 'Nom du groupe'
    ])
    ->add('matiere', EntityType::class,
    [
      'class' => Matiere::class,
      'attr' => [
        'class' => 'form-control select2'
      ]
    ])
    ->add('save', SubmitType::class,[
      'label' => 'Modifier les utilisateurs du groupe',
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
