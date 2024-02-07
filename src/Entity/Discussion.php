<?php

namespace App\Entity;

use App\Repository\DiscussionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionRepository::class)]
class Discussion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idemmeteur = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idrecepteur = null;

    #[ORM\Column(length: 500)]
    private ?string $contenu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmmeteur(): ?Utilisateur
    {
        return $this->idemmeteur;
    }

    public function setIdEmmeteur(?Utilisateur $idemmeteur): static
    {
        $this->idemmeteur = $idemmeteur;

        return $this;
    }

    public function getIdRecepteur(): ?Utilisateur
    {
        return $this->idrecepteur;
    }

    public function setIdRecepteur(?Utilisateur $idrecepteur): static
    {
        $this->idrecepteur = $idrecepteur;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }
}
