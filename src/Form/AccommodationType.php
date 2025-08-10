
<?php

namespace LocalAccommodationBundle\Form;

use Symfony\Component\Form\AbstractType;
use LocalAccommodationBundle\Entity\Accommodation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccommodationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'local_accommodation.accommodations.name',
            ])
            ->add('address', TextType::class, [
                'label' => 'local_accommodation.accommodations.address',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'local_accommodation.accommodations.description',
                'required' => false,
            ])
            ->add('capacity', IntegerType::class, [
                'label' => 'local_accommodation.accommodations.capacity',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accommodation::class,
        ]);
    }
}
