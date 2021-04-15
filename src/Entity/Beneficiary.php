<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BeneficiaryRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=BeneficiaryRepository::class)
 */
class Beneficiary
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le nom ne peut contenir de nombre")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Regex(
     *     pattern="/\d/",
     *     match=false,
     *     message="Le prénom ne peut contenir de nombre")
     */
    private $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="beneficiaries")
     */
    private $connectUser;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="beneficiaryTransaction")
     */
    private $transactionBeneficiary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getValidation(): ?bool
    {
        return $this->validation;
    }

    public function setValidation(bool $validation): self
    {
        $this->validation = $validation;

        return $this;
    }

    public function getConnectUser(): ?User
    {
        return $this->connectUser;
    }

    public function setConnectUser(?User $connectUser): self
    {
        $this->connectUser = $connectUser;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactionBeneficiary(): Collection
    {
        return $this->transactionBeneficiary;
    }

    public function addTransactionBeneficiary(Transaction $idTransactionBeneficiary): self
    {
        if (!$this->transactionBeneficiary->contains($idTransactionBeneficiary)) {
            $this->transactionBeneficiary[] = $idTransactionBeneficiary;
            $idTransactionBeneficiary->setBeneficiaryTransaction($this);
        }

        return $this;
    }

    public function removeTransactionBeneficiary(Transaction $idTransactionBeneficiary): self
    {
        if ($this->transactionBeneficiary->removeElement($idTransactionBeneficiary)) {
            // set the owning side to null (unless already changed)
            if ($idTransactionBeneficiary->getBeneficiaryTransaction() === $this) {
                $idTransactionBeneficiary->setBeneficiaryTransaction(null);
            }
        }

        return $this;
    }
}
