<?php

namespace UpjvBundle\Form;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UpjvBundle\Entity\Groupe;
use UpjvBundle\Entity\MatiereParcours;
use UpjvBundle\Entity\Parcours;

class EmailType extends AbstractType
{

    /** @var EntityManager */
    private $em;

    public function buildForm (FormBuilderInterface $builder, array $options) {

        /**
         * Parameters
         */
        $this->em = $options['em'];

        $builder
            ->add('listParcours', EntityType::class, array(
                'label' => 'Sélectionnez un ou plusieurs parcours :',
                'class' => 'UpjvBundle:Parcours',
                'multiple' => 'true',
                'attr' => [
                    'class' => 'js-example-basic-multiple form-control'
                ]
            ))
            ->add('object', TextType::class, array(
                'label' => 'Objet :',
                'attr' => [
                    'class' => 'form-control'
                ]
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message :',
                'attr' => [
                    'class' => 'form-control textarea-width'
                ]
            ))
            ->add('save', SubmitType::class, [
                'label' => "Envoyer",
                'attr' => [
                    'class' => 'btn btn-block btn-lg btn-blue'
                ]
            ]);

        $formMatiere = function (FormInterface $form, $listParcours = null) {

            $listMatiereParcours = null === $listParcours ? array() : $this->em->getRepository(MatiereParcours::class)->findMatieresByParcours($listParcours);

            $listMatiere = array();
            /** @var MatiereParcours $matiereParcours */
            foreach ($listMatiereParcours as $matiereParcours) {
                array_push($listMatiere, $matiereParcours->getMatieres());
            }

            $form->add('listMatiere', EntityType::class, array(
                'label' => 'Sélectionnez une ou plusieurs matières :',
                'class' => 'UpjvBundle:Matiere',
                'choices' => $listMatiere,
                'multiple' => true,
                'required' => false,
                'attr' => [
                    'class' => 'js-example-basic-multiple form-control'
                ]
            ));
        };

        $formGroupe = function (FormInterface $form, array $listMatiere = null) {
            $listGroupe = null === $listMatiere ? array() : $this->em->getRepository(Groupe::class)->findByMatiere($listMatiere);

            $form->add('listGroupe', EntityType::class, array(
                'label' => 'Sélectionnez un ou plusieurs groupes :',
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
            function (FormEvent $event) use ($formMatiere) {
                $data = $event->getData();

                $formMatiere($event->getForm(), $data->getListParcours());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formGroupe) {
                $data = $event->getData();

                $formGroupe($event->getForm(), $data->getListMatiere());
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formMatiere) {
                $data = $event->getData();

                $listParcours = $data['listParcours'];

                $formMatiere($event->getForm(), $listParcours);
            }
        );

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($formGroupe) {
                $data = $event->getData();

                $listMatiere = array_key_exists('listMatiere', $data) ? $data['listMatiere'] : null;

                $formGroupe($event->getForm(), $listMatiere);
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