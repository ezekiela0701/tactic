<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type' ,  ChoiceType::class , [
                'required'=>true,
                'label'  => "Type de compte:",
                'attr'=>[
                    'class'=>'form-control',
                ],
                'choices'  => [
                    "Etudiant"   => "Etudiant",
                    "Professeur" => "Professeur",
                ],
            ] )
            // ->add('name' , TextType::class,[
            //     'label' => "Nom *",
            //     'attr' => [
            //         'class' => 'form-control' 
            //     ]] )
            ->add('firstname'  , TextType::class,[
                'label' => "Prenom *",
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('email' , EmailType::class,[
                'label' => "Email *",
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('password' , PasswordType::class,[
                'label' => "Password *",
                'attr' => [
                    'class' => 'form-control'
                ]])
            ->add('confirm_password' , PasswordType::class,[
                'label' => "Confirm password *",
                'attr' => [
                    'class' => 'form-control'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
