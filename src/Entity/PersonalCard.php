<?php

namespace App\Entity;

use App\Repository\PersonalCardRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalCardRepository::class)]
class PersonalCard
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Fam = null;

    #[ORM\Column(length: 255)]
    private ?string $Tel = null;

    #[ORM\Column(length: 255)]
    private ?string $Addr = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFam(): ?string
    {
        return $this->Fam;
    }

    public function setFam(string $Fam): static
    {
        $this->Fam = $Fam;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(string $Tel): static
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getAddr(): ?string
    {
        return $this->Addr;
    }


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
