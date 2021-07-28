<?php

namespace App\Form;

use App\Entity\Subject;
use App\Entity\ClassSchool;
use App\Repository\ClassSchoolRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name' , TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ] , 
                'label' => ' Matière'
            ])
            ->add('teacher', TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ] , 
                'label' => ' Prof'
            ])
            // ->add('slug', TextType::class , [
            //     'attr' => [
            //         'class' => 'form-control'
            //     ] , 
            //     'label' => ' Slug'
            // ])
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
            ->add('classschool', EntityType::class, [
                'class'=> ClassSchool::class,
                'query_builder' => function(ClassSchoolRepository $er) {
                    return $er  ->createQueryBuilder('cs')
                                ->andWhere('cs.status = :status')
                                ->setParameter('status' , 1) ;  
                },
                'attr' => [
                    'class'=>'form-control',
                ] ,
                'choice_label' => 'name',
                'label' => 'Classe  de ',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Subject::class,
        ]);
    }
}
