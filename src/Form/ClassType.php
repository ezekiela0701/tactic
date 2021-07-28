<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\ClassSchool;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('scolaryear' , TextType::class, [
                'required'=>true,
                'label'=>" Année scolaire",
                'attr'=>[
                    'class'=>'form-control',
                    'maxlength'=>'180',
                ]
            ])
            // ->add('name', TextType::class, [
            //     'required'=>true,
            //     'label'=>"Classe de",
            //     'attr'=>[
            //         'class'=>'form-control',
            //         'maxlength'=>'180',
            //     ]
            // ])
            ->add('user',  EntityType::class, [
                'class' => User::class,
                // 'query_builder' => function (EntityRepository $user)
                // {
                //     return $user->createQueryBuilder('u')->Where('u.type = :' ,'Etudiant') ;
                // } , 
                'choice_label' => 'firstname',
                'label' => 'Classe de',
                'attr' => [
                    'class' => 'form-control',
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
            // ->add('circular')
            // ->add('schedule')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ClassSchool::class,
        ]);
    }
}
