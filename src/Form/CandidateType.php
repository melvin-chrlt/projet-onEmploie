<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Candidate;
use App\Entity\ContractType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('firstName')
            // ->add('lastName')
            // ->add('email')
            // ->add('phone')
            // ->add('roles')
            // ->add('password')
            ->add('categories', EntityType::class, [
                'choice_label' => 'label',
                'class' => Category::class,
                'multiple' => true,
                'required' => true,
                'expanded' => true,
            ])
            ->add('contractType', EntityType::class, [
                'choice_label' => 'label',
                'class' => ContractType::class,
                'multiple' => true,
                'required' => true,
                'expanded' => true,
            ]);
            // ->add('contractType');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
