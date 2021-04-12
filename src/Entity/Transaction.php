<?php

namespace App\Entity;

use App\Entity\Beneficiary;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransactionRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Assert\GreaterThanOrEqual(0)
     */
    private $debit;

    /**
     * @ORM\ManyToOne(targetEntity=Beneficiary::class, inversedBy="transactionBeneficiary")
     */
    private $beneficiaryTransaction;

    /**
     * @ORM\ManyToOne(targetEntity=Bank::class, inversedBy="transactions")
     */
    private $connectBank;

    private $choixBank;
    private $choixBeneficiary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDebit(): ?float
    {
        return $this->debit;
    }

    public function setDebit(?float $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    public function getBeneficiaryTransaction(): ?Beneficiary
    {
        return $this->beneficiaryTransaction;
    }

    public function setBeneficiaryTransaction(?Beneficiary $beneficiaryTransaction): self
    {
        $this->beneficiaryTransaction = $beneficiaryTransaction;

        return $this;
    }

    public function getConnectBank(): ?Bank
    {
        return $this->connectBank;
    }

    public function setConnectBank(?Bank $connectBank): self
    {
        $this->connectBank = $connectBank;

        return $this;
    }

    public function getChoixBank(): ?Bank
    {
        return $this->choixBank;
    }

    public function setChoixBank(?Bank $choixBank): self
    {
        $this->choixBank = $choixBank;

        return $this;
    }

    public function getChoixBeneficiary(): ?Beneficiary
    {
        return $this->choixBeneficiary;
    }

    public function setChoixBeneficiary(?Beneficiary $choixBeneficiary): self
    {
        $this->choixBeneficiary = $choixBeneficiary;

        return $this;
    }
}
