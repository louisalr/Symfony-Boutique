<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label'=> 'Nom de l\'adrese',
                'attr' => [
                    'placeholder' => 'Nommer votre adresse'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label'=> 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre prénom'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label'=> 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('company', TextType::class, [
                'label'=> 'Société ',
                'attr' => [
                    'placeholder' => '(facultatif)'
                ]
            ])
            ->add('address', TextType::class, [
                'label'=> 'Votre adresse',
                'attr' => [
                    'placeholder' => 'Entre votre adresse'
                ]
            ])
            ->add('code_postal', TextType::class, [
                'label'=> 'Code posta',
                'attr' => [
                    'placeholder' => 'Entrez code postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label'=> 'Ville',
                'attr' => [
                    'placeholder' => 'Entrez votre ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label'=> 'Pays',
                'attr' => [
                    'placeholder' => 'Entrez votre pays'
                ]
            ])
            ->add('phone', TelType::class, [
                'label'=> 'Numéro de téléphone',
                'attr' => [
                    'placeholder' => '06XXXXXXXX'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label'=> 'Valider mon adresse',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
