<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class CreateAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, ['required' => true])
            ->add('lastname', TextType::class, ['required' => true])
            ->add('mail', TextType::class, ['required' => true])
            ->add('password', PasswordType::class, ['required' => true])
            ->add('confirmPassword', PasswordType::class, ['required' => true])
            //->add('role')
            ->add('identityFile', FileType::class, [
                "mapped" => false,
                'required' => true,
                "multiple" => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8192k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'image/jpeg', 'image/png',
                        ],
                        'mimeTypesMessage' => 'Merci de rentrer un document PDF valide',
                    ])
                ],

            ])
            //->add('validation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
