<?php

namespace App\Form;

use App\Form\Type\TableSettingsType;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TableSettingsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var UserInterface $user */
        $user = $options['user'];
        $choices = $options['columns'];

        $builder
            ->add('visibility', ChoiceType::class, [
                'choices' => $choices,
                'label' => 'Columns',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                'by_reference' => false,
            ])
            ->add('limit', ChoiceType::class, [
                'choices' => [
                    '10' => 10,
                    '25' => 25,
                    '50' => 50,
                    '100' => 100,
                    '250' => 250,
                    '500' => 500,
                    '1000' => 1000,
                ],
                'label' => 'Entries per page',
                'required' => true,
                'by_reference' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TableSettingsType::class,
            'user' => null,
            'columns' => [],
        ]);
    }
}
