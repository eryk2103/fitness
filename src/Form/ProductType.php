<?php

namespace App\Form;

use App\Entity\Product;
use App\Enum\UnitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('brand')
            ->add('barcode')
            ->add('unit', EnumType::class, [
                'class' => UnitType::class,
                'required' => true
            ])
            ->add('size')
            ->add('servingSize')
            ->add('calories')
            ->add('protein')
            ->add('carbs')
            ->add('fats')
            ->add('sugar')
            ->add('submit', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
