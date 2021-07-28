<?php

namespace App\Form;

use App\Entity\Carousel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CarouselType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image' ,FileType::class , [
                'attr' => [
                    'class' => 'form-control' ,
                ] ,  
                    'mapped' => false,
                    'multiple' => true , 
                    'required' => false ,
                'label' => 'Images'
            ])
            ->add('title' , TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ] , 
                'label' => ' Titre'
            ])
            ->add('description' , TextareaType::class , [
                'required'=>false,
                'label'=>'Description',
                'attr'=>[
                    'class'=>'form-control',
                    'maxlength'=>'750',
                ]
            ])
            ->add('status' , ChoiceType::class, [
                'required'=>true,
                'label'  => "Statut:",
                'attr'=>[
                    'class'=>'form-control',
                ],
                'choices'  => [
                    "Activer" => "1",
                    "Desativer" => "0",
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Carousel::class,
        ]);
    }
}
