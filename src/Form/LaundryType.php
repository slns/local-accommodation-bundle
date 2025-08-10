<?php

namespace LocalAccommodationBundle\Form;

use LocalAccommodationBundle\Entity\Laundry;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LaundryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('item', TextType::class, [
                'label' => 'local_accommodation.laundry.item',
            ])
            ->add('deliveredAt', DateTimeType::class, [
                'label' => 'local_accommodation.laundry.delivered_at',
            ])
            ->add('receivedAt', DateTimeType::class, [
                'label' => 'local_accommodation.laundry.received_at',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Laundry::class,
        ]);
    }
}
