<?php

namespace App\Form;

use App\Entity\Bank;
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
            ->add('description')
            ->add('debit', MoneyType::class)

            ->add('choixBank', EntityType::class, [
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
