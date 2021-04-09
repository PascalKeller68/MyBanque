<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RolesRepository::class)
 */
class Roles
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
    private $roleName;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="rolesUtilisateur")
     */
    private $rolesUser;

    public function __construct()
    {
        $this->rolesUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): self
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getRolesUser(): Collection
    {
        return $this->rolesUser;
    }

    public function addRolesUser(User $rolesUser): self
    {
        if (!$this->rolesUser->contains($rolesUser)) {
            $this->rolesUser[] = $rolesUser;
        }

        return $this;
    }

    public function removeRolesUser(User $rolesUser): self
    {
        $this->rolesUser->removeElement($rolesUser);

        return $this;
    }
}
