<?php

namespace App\Form;

use App\Entity\Bank;
use App\Entity\Beneficiary;
use App\Entity\User;
use App\Entity\Transaction;
use Doctrine\ORM\EntityRepository;
use PhpParser\Builder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use function Symfony\Component\String\b;

class FormTransationType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('description', TextType::class, ['required' => true])
            ->add('debit', MoneyType::class, ['required' => true])

            ->add('choixBank', EntityType::class, [
                'required' => true,
                'class' => Bank::class,
                'query_builder' => function (EntityRepository $er) {
                    $q = $er->createQueryBuilder('b');
                    return $q->select('b')
                        ->from(User::class, 'u')
                        ->where('u.id = b.connectAccount')
                        ->andWhere('u.mail = :mail')
                        ->orderBy('b.bankName', 'ASC')
                        ->setParameter('mail', $this->token->getToken()->getUser()->getUsername());
                },
                'choice_value' => 'id',
                'choice_label' => function (?Bank $banks) {
                    return $banks ? strtoupper($banks->getBankName()) : '';
                },
            ])

            ->add('choixBeneficiary', EntityType::class, [
                'class' => Beneficiary::class,
                'query_builder' => function (EntityRepository $er) {
                    $q = $er->createQueryBuilder('b');
                    return $q->select('b')
                        ->from(User::class, 'u')
                        ->where('u.id = b.connectUser')
                        ->andWhere('u.mail = :mail')
                        ->andWhere('b.validation = 1')
                        ->orderBy('b.name', 'ASC')
                        ->setParameter('mail', $this->token->getToken()->getUser()->getUsername());
                },
                'choice_value' => 'id',
                'choice_label' => function (?Beneficiary $beneficiarys) {
                    return $beneficiarys ? strtoupper($beneficiarys->getName() . " " . $beneficiarys->getLastName()) : '';
                },
            ])
            //->add('credit')
            //->add('connectBank')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
