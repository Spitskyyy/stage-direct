<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('password')
            //->add('roles')
            ->add('roles', ChoiceType::class, [

                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Etudiant' => 'ROLE_STUDENT',
                    'Professeur' => 'ROLE_TEACHER',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Super administrateur' => 'ROLE_SUPER_ADMIN',

                ],
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
