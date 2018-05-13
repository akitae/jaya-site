<?php

namespace UpjvBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;

class EmailType extends AbstractType
{

    /** @var EntityManager */
    private $em;

    public function buildForm (FormBuilderInterface $builder, array $options) {

        $this->em = $options['em'];

        $builder
            ->add('listParcours', EntityType::class, array(
                'class' => 'UpjvBundle:Parcours',
                'multiple' => 'true',
                'choice_value' => function (Parcours $parcours = null) {
                    return $parcours ? $parcours->getId() : '';
                },
                'attr' => [
                    'class' => 'js-example-basic-multiple form-control'
                ]
            ))
            ->add('save', SubmitType::class, [
                'label' => "Envoyer",
                'attr' => [
                    'class' => 'btn btn-block btn-lg btn-blue'
                ]
            ]);

        $formModifier = function (FormInterface $form, $listParcours = null) {

            $listMatiereParcours = null === $listParcours ? array() : $this->em->getRepository(MatiereParcours::class)->findMatieresByParcours($listParcours);

            $listMatiere = array();
            /** @var MatiereParcours $matiereParcours */
            foreach ($listMatiereParcours as $matiereParcours) {
                array_push($listMatiere, $matiereParcours->getMatieres());
            }

            $form->add('listMatiere', EntityType::class, array(
                'class' => 'UpjvBundle:Matiere',
                'choices' => $listMatiere,
                'multiple' => 'true',
                'required' => false,
                'attr' => [
                    'class' => 'js-example-basic-multiple form-control'
                ]
            ));
        };

        $formGroupe = function (FormInterface $form, array $listGroupe = null) {

            $listGroupe = null === $listGroupe ? array() : array();

            $form->add('listGroupe', EntityType::class, array(
                'class' => 'UpjvBundle:Groupe',
                'choices' => $listGroupe,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'js-example-basic-multiple form-control'
                ]
            ));
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getListParcours());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formGroupe) {
                $data = $event->getData();

                $formGroupe($event->getForm(), $data->getListGroupe());
            }
        );

        $builder->get('listParcours')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $listParcours = $event->getForm()->getData();

                $formModifier($event->getForm()->getParent(), $listParcours);
            }
        );

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'em' => null
        ));
    }


}