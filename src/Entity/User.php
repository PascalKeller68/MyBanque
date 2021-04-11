<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"mail"},
 *     message="Email déjà utilisé")
 */
class User implements UserInterface
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
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 4,
     *      max = 50,
     *      minMessage = "Vous devez entrer au moins {{ limit }} caractères",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     */
    private $password;
    /**
     * @Assert\EqualTo(propertyPath="password", message="Votre mot de passe n'est pas identique")
     */
    private $confirmPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identityFile;

    /**
     * @ORM\Column(type="boolean")
     */
    private $validation;

    /**
     * @ORM\ManyToMany(targetEntity=Roles::class, mappedBy="rolesUser")
     */
    private $rolesUtilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Bank::class, mappedBy="connectAccount")
     */
    private $banks;

    /**
     * @ORM\OneToMany(targetEntity=Beneficiary::class, mappedBy="connectUser")
     */
    private $beneficiaries;

    public function __construct()
    {
        $this->rolesUtilisateur = new ArrayCollection();
        $this->banks = new ArrayCollection();
        $this->beneficiaries = new ArrayCollection();
    }

    public function getUsername()
    {
        return $this->mail;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function getIdentityFile(): ?string
    {
        return $this->identityFile;
    }

    public function setIdentityFile(string $identityFile): self
    {
        $this->identityFile = $identityFile;

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

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
    }
    public function getRoles()
    {
        $roleArray = $this->getRolesUtilisateur()->getValues();
        $array = [];

        foreach ($roleArray as $role) {
            $array[] = $role->getRoleName();
        }

        return $array;
    }

    /**
     * @return Collection|Roles[]
     */
    public function getRolesUtilisateur(): Collection
    {
        return $this->rolesUtilisateur;
    }

    public function addRolesUtilisateur(Roles $rolesUtilisateur): self
    {
        if (!$this->rolesUtilisateur->contains($rolesUtilisateur)) {
            $this->rolesUtilisateur[] = $rolesUtilisateur;
            $rolesUtilisateur->addRolesUser($this);
        }

        return $this;
    }

    public function removeRolesUtilisateur(Roles $rolesUtilisateur): self
    {
        if ($this->rolesUtilisateur->removeElement($rolesUtilisateur)) {
            $rolesUtilisateur->removeRolesUser($this);
        }

        return $this;
    }

    /**
     * @return Collection|Bank[]
     */
    public function getBanks(): Collection
    {
        return $this->banks;
    }

    public function addBank(Bank $bank): self
    {
        if (!$this->banks->contains($bank)) {
            $this->banks[] = $bank;
            $bank->setConnectAccount($this);
        }

        return $this;
    }

    public function removeBank(Bank $bank): self
    {
        if ($this->banks->removeElement($bank)) {
            // set the owning side to null (unless already changed)
            if ($bank->getConnectAccount() === $this) {
                $bank->setConnectAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Beneficiary[]
     */
    public function getBeneficiaries(): Collection
    {
        return $this->beneficiaries;
    }

    public function addBeneficiary(Beneficiary $beneficiary): self
    {
        if (!$this->beneficiaries->contains($beneficiary)) {
            $this->beneficiaries[] = $beneficiary;
            $beneficiary->setConnectUser($this);
        }

        return $this;
    }

    public function removeBeneficiary(Beneficiary $beneficiary): self
    {
        if ($this->beneficiaries->removeElement($beneficiary)) {
            // set the owning side to null (unless already changed)
            if ($beneficiary->getConnectUser() === $this) {
                $beneficiary->setConnectUser(null);
            }
        }

        return $this;
    }
}
