<?php

namespace App\Form;

use App\Entity\Beneficiary;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddBeneficiaryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['required' => true],
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['required' => true]
            ])
            //->add('validation')
            //->add('connectUser')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Beneficiary::class,
        ]);
    }
}
