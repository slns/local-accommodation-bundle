<?php

namespace LocalAccommodationBundle\Form;

use LocalAccommodationBundle\Entity\Accommodation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccommodationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['label' => 'Name'])
            ->add('address', \Symfony\Component\Form\Extension\Core\Type\TextType::class, ['label' => 'Address'])
            ->add('description', \Symfony\Component\Form\Extension\Core\Type\TextareaType::class, ['label' => 'Description', 'required' => false])
            ->add('capacity', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, ['label' => 'Capacity'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accommodation::class,
        ]);
    }
}
