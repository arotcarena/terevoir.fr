<?php

namespace App\Form;

use App\Form\TestSearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchFirstName')
            ->add('searchLastName')
            ->add('searchAge')
            ->add('searchCityFirst')
            ->add('searchCityLast')
            ->add('myFirstName')
            ->add('myLastName')
            ->add('myBirthYear')
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'method' => 'POST',
            'data_class' => TestSearchData::class,
            'csrf_protection' => false
        ]);
    }

}
