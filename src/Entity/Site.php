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
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SiteRepository::class)]
#[ApiResource(
    description: 'Site of potential old money spots',
    operations: [
        new Get(uriTemplate: '/site/{id}'), // Read
        new GetCollection(uriTemplate: '/site/liste'), //Read
        new Post(uriTemplate: '/site/ajout'), // create
        new Put(uriTemplate: '/site/modification/{id}'),// replace (remplace toute les information même inchangé)
        new Patch(uriTemplate: '/site/modification/{id}'), // update (regarde les informations déjà rentré et change cell qui sont différentes)
        new Delete(uriTemplate: '/site/suppression/{id}') // delete
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

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $typetimer = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $tempsinitial = null;

    #[ORM\Column(length: 11, nullable: true)]
    private ?string $tempsrestant = null;

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

    public function getTypeTimer(): ?string
    {
        return $this->typetimer;
    }

    public function setTypeTimer(?string $typetimer): static
    {
        $this->typetimer = $typetimer;

        return $this;
    }

    public function getTempsInitial(): ?string
    {
        return $this->tempsinitial;
    }

    public function setTempsInitial(?string $tempsinitial): static
    {
        $this->tempsinitial = $tempsinitial;

        return $this;
    }

    public function getTempsRestant(): ?string
    {
        return $this->tempsrestant;
    }

    public function setTempsRestant(?string $tempsrestant): static
    {
        $this->tempsrestant = $tempsrestant;

        return $this;
    }
}
