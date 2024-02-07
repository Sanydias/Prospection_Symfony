<?php

namespace App\Entity;

use App\Repository\FavoriRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriRepository::class)]
class Favori
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'favoris')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idutlisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $idsite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtlisateur(): ?Utilisateur
    {
        return $this->idutlisateur;
    }

    public function setIdUtlisateur(?Utilisateur $idutlisateur): static
    {
        $this->idutlisateur = $idutlisateur;

        return $this;
    }

    public function getIdSite(): ?Site
    {
        return $this->idsite;
    }

    public function setIdSite(?Site $idsite): static
    {
        $this->idsite = $idsite;

        return $this;
    }
}
