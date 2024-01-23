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
    private ?Utilisateur $id_emmeteur = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $id_recepteur = null;

    #[ORM\Column(length: 500)]
    private ?string $contenu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmmeteur(): ?Utilisateur
    {
        return $this->id_emmeteur;
    }

    public function setIdEmmeteur(?Utilisateur $id_emmeteur): static
    {
        $this->id_emmeteur = $id_emmeteur;

        return $this;
    }

    public function getIdRecepteur(): ?Utilisateur
    {
        return $this->id_recepteur;
    }

    public function setIdRecepteur(?Utilisateur $id_recepteur): static
    {
        $this->id_recepteur = $id_recepteur;

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
