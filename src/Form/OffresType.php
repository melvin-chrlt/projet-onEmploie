<?php

namespace App\Form;

use App\Entity\Offres;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('place')
            ->add('salary')
            ->add('description')
            ->add('categories', EntityType::class, [
                'choice_label' => 'label',
                'class' => Category::class,
                'multiple' => true,
                'required' => true,
                'expanded' => true,
            ])
            ->add('contractType');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offres::class,
        ]);
    }
}
