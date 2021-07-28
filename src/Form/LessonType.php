<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Subject;
use App\Entity\ClassSchool;
use App\Repository\UserRepository;
use App\Repository\SubjectRepository;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use App\Repository\ClassSchoolRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LessonType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
            // ->add('type', ChoiceType::class, [
            //     'required'=>true,
            //     'label'  => "Type de Lecon:",
            //     'attr'=>[
            //         'class'=>'form-control',
            //     ],
            //     'choices'  => [
            //         "Fichier" => "Fichier",
            //         "Videos"  => "Videos",
            //     ],
            // ])
            ->add('chapter', TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ] , 
                'label' => ' Chapitre'
            ])
            ->add('title', TextType::class , [
                'attr' => [
                    'class' => 'form-control'
                ] , 
                'label' => ' Titre'
            ])
            ->add('document',FileType::class , [
                'attr' => [
                    'class' => 'form-control' ,
                ] ,  
                    'mapped' => false,
                    'multiple' => true , 
                    'required' => false ,
                'label' => 'Documents'
            ])
            ->add('videos',FileType::class , [
                'attr' => [
                    'class' => 'form-control' ,
                ] ,  
                    'mapped' => false,
                    'multiple' => true , 
                    'required' => false ,
                'label' => 'Videos'
            ])
            ->add('status', ChoiceType::class, [
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
            'data_class' => Lesson::class,
        ]);
    }

}
