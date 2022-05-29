<?php

namespace App\Form;

use App\Entity\CarteTodo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCarteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TypeTextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Exemple : Faire le ménage !'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer la carte'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CarteTodo::class,
        ]);
    }
}
