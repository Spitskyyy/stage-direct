<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email');
        $builder->add('username');
        if ($options['type_user'] == 'admin') {
            $builder->add('roles', ChoiceType::class, [
                'choices' => [
                    'STUDENT' => 'ROLE_STUDENT',
                    'TEACHER' => 'ROLE_TEACHER',
                    'ADMINISTRATEUR' => 'ROLE_ADMIN',
                    'SUPER_ADMINISTRATEUR' => 'ROLE_SUPER_ADMIN',
                ],
                'multiple' => true,
            ]);
        }
        $builder->add('password');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'type_user' => '',
        ]);
    }
}
