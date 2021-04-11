<?php

namespace App\Entity;

use App\Repository\BeneficiaryRepository;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
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
}
