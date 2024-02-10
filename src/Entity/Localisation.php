<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\LocalisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
#[ApiResource(
    description: 'French places',
    operations: [
        new Get(uriTemplate: '/localisation/{id}'), // Read
        new GetCollection(uriTemplate: '/localisation/liste'), //Read
        new Post(uriTemplate: '/localisation/ajout'), // create
        new Put(uriTemplate: '/localisation/modification/{id}'),// replace (remplace toute les information même inchangé)
        new Patch(uriTemplate: '/localisation/modification/{id}'), // update (regarde les informations déjà rentré et change cell qui sont différentes)
        new Delete(uriTemplate: '/localisation/suppression/{id}') // delete
    ]
)]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $codecommuneinsee = null;

    #[ORM\Column(length: 50)]
    private ?string $nomcommunepostal = null;

    #[ORM\Column]
    private ?int $codepostal = null;

    #[ORM\Column(length: 50)]
    private ?string $libelleacheminement = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ligne5 = null;

    #[ORM\Column(length: 15)]
    private ?string $latitude = null;

    #[ORM\Column(length: 15)]
    private ?string $longitude = null;

    #[ORM\Column]
    private ?int $codecommune = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $article = null;

    #[ORM\Column(length: 50)]
    private ?string $nomcommune = null;

    #[ORM\Column(length: 50)]
    private ?string $nomcommunecomplet = null;

    #[ORM\Column]
    private ?int $codedepartement = null;

    #[ORM\Column(length: 50)]
    private ?string $nomdepartement = null;

    #[ORM\Column]
    private ?int $coderegion = null;

    #[ORM\Column(length: 50)]
    private ?string $nomregion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCommuneInsee(): ?int
    {
        return $this->codecommuneinsee;
    }

    public function setCodeCommuneInsee(int $codecommuneinsee): static
    {
        $this->codecommuneinsee = $codecommuneinsee;

        return $this;
    }

    public function getNomCommunePostal(): ?string
    {
        return $this->nomcommunepostal;
    }

    public function setNomCommunePostal(string $nomcommunepostal): static
    {
        $this->nomcommunepostal = $nomcommunepostal;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->codepostal;
    }

    public function setCodePostal(int $codepostal): static
    {
        $this->codepostal = $codepostal;

        return $this;
    }

    public function getLibelleAcheminement(): ?string
    {
        return $this->libelleacheminement;
    }

    public function setLibelleAcheminement(string $libelleacheminement): static
    {
        $this->libelleacheminement = $libelleacheminement;

        return $this;
    }

    public function getLigne5(): ?string
    {
        return $this->ligne5;
    }

    public function setLigne5(?string $ligne5): static
    {
        $this->ligne5 = $ligne5;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(string $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCodeCommune(): ?int
    {
        return $this->codecommune;
    }

    public function setCodeCommune(int $codecommune): static
    {
        $this->codecommune = $codecommune;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(?string $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getNomCommune(): ?string
    {
        return $this->nomcommune;
    }

    public function setNomCommune(string $nomcommune): static
    {
        $this->nomcommune = $nomcommune;

        return $this;
    }

    public function getNomCommuneComplet(): ?string
    {
        return $this->nomcommunecomplet;
    }

    public function setNomCommuneComplet(string $nomcommunecomplet): static
    {
        $this->nomcommunecomplet = $nomcommunecomplet;

        return $this;
    }

    public function getCodeDepartement(): ?int
    {
        return $this->codedepartement;
    }

    public function setCodeDepartement(int $codedepartement): static
    {
        $this->codedepartement = $codedepartement;

        return $this;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nomdepartement;
    }

    public function setNomDepartement(string $nomdepartement): static
    {
        $this->nomdepartement = $nomdepartement;

        return $this;
    }

    public function getCodeRegion(): ?int
    {
        return $this->coderegion;
    }

    public function setCodeRegion(int $coderegion): static
    {
        $this->coderegion = $coderegion;

        return $this;
    }

    public function getNomRegion(): ?string
    {
        return $this->nomregion;
    }

    public function setNomRegion(string $nomregion): static
    {
        $this->nomregion = $nomregion;

        return $this;
    }
}
