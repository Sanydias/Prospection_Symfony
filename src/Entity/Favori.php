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
    private ?Utilisateur $id_utlisateur = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Site $id_site = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtlisateur(): ?Utilisateur
    {
        return $this->id_utlisateur;
    }

    public function setIdUtlisateur(?Utilisateur $id_utlisateur): static
    {
        $this->id_utlisateur = $id_utlisateur;

        return $this;
    }

    public function getIdSite(): ?Site
    {
        return $this->id_site;
    }

    public function setIdSite(?Site $id_site): static
    {
        $this->id_site = $id_site;

        return $this;
    }
}
