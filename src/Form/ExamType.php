<?php

namespace App\Form;

use App\Entity\Exam;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ExamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trimester' , ChoiceType::class, [
                'required'=>true,
                'label'  => "Trimestre",
                'attr'=>[
                    'class'=>'form-control',
                ],
                'choices'  => [
                    "Premier trimestre"     => "1",
                    "Second trimestre"      => "2",
                    "Troisieme trimestre"   => "3",
                ],
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
            // ->add('slug')
            // ->add('subject')
            // ->add('classSchool')
            ->add('document',FileType::class , [
                'attr' => [
                    'class' => 'form-control' ,
                ] ,  
                    'mapped' => false,
                    'multiple' => true , 
                    'required' => false ,
                'label' => 'Documents'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Exam::class,
        ]);
    }
}
