<?php

namespace App\Form;

use App\Entity\Schedule;
use App\Entity\ClassSchool;
use App\Repository\ClassSchoolRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('programm' , TextareaType::class , [
                'required'=>false,
                'label'=>'Emploie du temps',
                'attr'=>[
                    'class'=>'form-control',
                    'maxlength'=>'750',
                ]
            ] )
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
            'data_class' => Schedule::class,
        ]);
    }
}
