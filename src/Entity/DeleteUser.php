<?php

namespace App\Entity;

use App\Repository\DeleteUserRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeleteUserRepository::class)
 */
class DeleteUser
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
    private $documentSuppression;


    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $connectUserDel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentSuppression(): ?string
    {
        return $this->documentSuppression;
    }

    public function setDocumentSuppression(string $documentSuppression): self
    {
        $this->documentSuppression = $documentSuppression;

        return $this;
    }


    public function getConnectUserDel(): ?User
    {
        return $this->connectUserDel;
    }

    public function setConnectUserDel(User $connectUserDel): self
    {
        $this->connectUserDel = $connectUserDel;

        return $this;
    }
}
