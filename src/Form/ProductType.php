<?php

namespace App\Form;

use App\Entity\Product;
use App\Enum\UnitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name *'
            ])
            ->add('brand')
            ->add('barcode')
            ->add('unit', EnumType::class, [
                'class' => UnitType::class,
                'label' => 'Unit *'
            ])
            ->add('size', NumberType::class, [
                'label' => 'Amount *'
            ])
            ->add('servingSize', NumberType::class, [
                'label' => 'Serving size'
            ])
            ->add('calories', NumberType::class, [
                'label' => 'Calories (kcal per 100) *'
            ])
            ->add('protein', NumberType::class, [
                'label' => 'Protein (g per 100) *'
            ])
            ->add('carbs', NumberType::class, [
                'label' => 'Carbs (g per 100) *'
            ])
            ->add('fats', NumberType::class, [
                'label' => 'Fats (g per 100) *'
            ])
            ->add('sugar', NumberType::class, [
                'label' => 'Sugar (g per 100)'
            ])
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
