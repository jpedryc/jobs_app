<?php

namespace App\Form;

use App\Entity\Position;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('github_guid')
            ->add('type')
            ->add('url')
            ->add('created_at')
            ->add('company')
            ->add('company_url')
            ->add('location')
            ->add('title')
            ->add('description')
            ->add('how_to_apply')
            ->add('company_logo')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Position::class,
        ]);
    }
}
