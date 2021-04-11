<?php

namespace App\Entity;

use App\Repository\BankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BankRepository::class)
 */
class Bank
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
    private $bankName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bankBalance;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="banks")
     */
    private $connectAccount;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="connectBank")
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankName(): ?string
    {
        return $this->bankName;
    }

    public function setBankName(string $bankName): self
    {
        $this->bankName = $bankName;

        return $this;
    }

    public function getBankBalance(): ?string
    {
        return $this->bankBalance;
    }

    public function setBankBalance(string $bankBalance): self
    {
        $this->bankBalance = $bankBalance;

        return $this;
    }

    public function getConnectAccount(): ?User
    {
        return $this->connectAccount;
    }

    public function setConnectAccount(?User $connectAccount): self
    {
        $this->connectAccount = $connectAccount;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setConnectBank($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getConnectBank() === $this) {
                $transaction->setConnectBank(null);
            }
        }

        return $this;
    }
}
