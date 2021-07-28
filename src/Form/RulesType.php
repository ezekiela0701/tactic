<?php

namespace App\Form;

use App\Entity\Rules;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RulesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content' , TextareaType::class , [
                'required'=>false,
                'label'=>'Reglement intérieur',
                'attr'=>[
                    'class'=>'form-control',
                    'maxlength'=>'750',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Rules::class,
        ]);
    }
}
