<?php

namespace App\Entity;

use App\Repository\CongeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CongeRepository::class)
 */
class Conge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbJours;

    /**
     * @ORM\Column(type="json")
     */
    private $Statut = [];

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="conges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->DateDebut;
    }

    public function setDateDebut(\DateTimeInterface $DateDebut): self
    {
        $this->DateDebut = $DateDebut;

        return $this;
    }

    public function getNbJours(): ?int
    {
        return $this->nbJours;
    }

    public function setNbJours(int $nbJours): self
    {
        $this->nbJours = $nbJours;

        return $this;
    }

    public function getStatut(): ?array
    {
        return $this->Statut;
        $statut[] = 'attente de validation';
    }

    public function setStatut(array $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
}
}
