<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\SiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ApiResource(
    description: 'Site of potential old money spots',
    operations: [
        new Get(uriTemplate: '/site/item/{id}'), // Read
        new GetCollection(uriTemplate: '/site/rechercher'), //Read List
        new Post(uriTemplate: '/admin/site/ajouter'), // Create
        new Put(uriTemplate: '/admin/site/modifier/{id}'),// Replace (remplace toute les information même inchangé)
        new Delete(uriTemplate: '/admin/site/supprimer/{id}') // Delete
    ]
)]
class Site
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $departement = null;

    #[ORM\Column(length: 50)]
    private ?string $commune = null;

    #[ORM\Column(length: 50)]
    private ?string $lieuxdit = null;

    #[ORM\Column(length: 50)]
    private ?string $interethistorique = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $lien = null;

    #[ORM\Column]
    private ?bool $timer = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateinitial = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $datefinal = null;

    #[ORM\OneToMany(mappedBy: 'site', targetEntity: Favori::class)]
    private Collection $favoris;

    public function __construct()
    {
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartement(): ?int
    {
        return $this->departement;
    }

    public function setDepartement(int $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getCommune(): ?string
    {
        return $this->commune;
    }

    public function setCommune(string $commune): static
    {
        $this->commune = $commune;

        return $this;
    }

    public function getLieuxdit(): ?string
    {
        return $this->lieuxdit;
    }

    public function setLieuxdit(string $lieuxdit): static
    {
        $this->lieuxdit = $lieuxdit;

        return $this;
    }

    public function getInterethistorique(): ?string
    {
        return $this->interethistorique;
    }

    public function setInterethistorique(string $interethistorique): static
    {
        $this->interethistorique = $interethistorique;

        return $this;
    }

    public function getlien(): ?string
    {
        return $this->lien;
    }

    public function setlien(?string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getTimer(): ?bool
    {
        return $this->timer;
    }

    public function setTimer(bool $timer): static
    {
        $this->timer = $timer;

        return $this;
    }

    public function getDateinitial(): ?\DateTimeInterface
    {
        return $this->dateinitial;
    }

    public function setDateinitial(?\DateTimeInterface $dateinitial): static
    {
        $this->dateinitial = $dateinitial;

        return $this;
    }

    public function getDatefinal(): ?\DateTimeInterface
    {
        return $this->datefinal;
    }

    public function setDatefinal(?\DateTimeInterface $datefinal): static
    {
        $this->datefinal = $datefinal;

        return $this;
    }

    /**
     * @return Collection<int, Favori>
     */
    public function getFavoris(): Collection
    {
        return $this->favoris;
    }

    public function addFavoris(Favori $favoris): static
    {
        if (!$this->favoris->contains($favoris)) {
            $this->favoris->add($favoris);
            $favoris->setSite($this);
        }

        return $this;
    }

    public function removeFavoris(Favori $favoris): static
    {
        if ($this->favoris->removeElement($favoris)) {
            // set the owning side to null (unless already changed)
            if ($favoris->getSite() === $this) {
                $favoris->setSite(null);
            }
        }

        return $this;
    }
}
