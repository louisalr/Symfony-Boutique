<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled'=>true,
                'label'=> 'Adresse email'
            ])
            ->add('firstname', TextType::class, [
                'disabled'=>true,
                'label'=> 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'disabled'=>true,
                'label'=> 'Nom'
            ])
            ->add('old_password', PasswordType::class, [
                'label'=>'Mon mot de passe actuel',
                'mapped'=>false,
                'attr'=>[
                    'placeholder'=>'Ancien mot de passe'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false, //pour pas le mapper à une valeur de User vu que new_password n'existe pas dans User
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identiques',
                'label' => 'Mon nouveau mot de passe',
                'required' => true,
                'first_options' => ['label' =>'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre nouveau mot de passe'
                    ]
                ],
                'second_options' => ['label' => 'Confirmer votre nouveau nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de resaisir votre nouveau mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Changer mot de passe"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
