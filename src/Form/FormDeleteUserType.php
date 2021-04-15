<?php

namespace App\Form;

use App\Entity\DeleteUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;



class FormDeleteUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('documentSuppression', FileType::class, [
                "mapped" => false,
                'required' => true,
                "multiple" => false,
                'constraints' => [
                    new File([
                        'maxSize' => '8192k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Merci de rentrer un document PDF valide',
                    ])
                ],


            ])
            //->add('connectUserDel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeleteUser::class,
        ]);
    }
}
