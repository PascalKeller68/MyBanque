<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $debit;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $credit;

    /**
     * @ORM\ManyToOne(targetEntity=Bank::class, inversedBy="transactions")
     */
    private $connectBank;

    private $choixBank;

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

    public function getDebit(): ?int
    {
        return $this->debit;
    }

    public function setDebit(?int $debit): self
    {
        $this->debit = $debit;

        return $this;
    }

    public function getCredit(): ?int
    {
        return $this->credit;
    }

    public function setCredit(?int $credit): self
    {
        $this->credit = $credit;

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
}
