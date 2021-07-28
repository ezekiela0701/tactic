<?php

namespace App\Form;

use App\Entity\HomeGallery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class HomeGalleryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file',FileType::class , [
                'attr' => [
                    'class' => 'form-control' ,
                ] ,  
                    'mapped' => false,
                    'multiple' => true , 
                    'required' => false ,
                'label' => 'Image ajouter à la gallerie'
            ] )
            // ->add('created')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HomeGallery::class,
        ]);
    }
}
