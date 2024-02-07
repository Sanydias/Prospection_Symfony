<?php

namespace App\Entity;

use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    private ?string $typepreference = null;

    #[ORM\Column(length: 50)]
    private ?string $lieu = null;

    #[ORM\ManyToOne(inversedBy: 'preferences')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idutilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePreference(): ?string
    {
        return $this->typepreference;
    }

    public function setTypePreference(string $typepreference): static
    {
        $this->typepreference = $typepreference;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): static
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idutilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idutilisateur): static
    {
        $this->idutilisateur = $idutilisateur;

        return $this;
    }
}
