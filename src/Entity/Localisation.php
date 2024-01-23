<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $code_commune_insee = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_commune_postal = null;

    #[ORM\Column]
    private ?int $code_postal = null;

    #[ORM\Column(length: 50)]
    private ?string $libelle_acheminement = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $ligne_5 = null;

    #[ORM\Column(length: 15)]
    private ?string $latitude = null;

    #[ORM\Column(length: 15)]
    private ?string $longitude = null;

    #[ORM\Column]
    private ?int $code_commune = null;

    #[ORM\Column(length: 4, nullable: true)]
    private ?string $article = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_commune = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_commune_complet = null;

    #[ORM\Column]
    private ?int $code_departement = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_departement = null;

    #[ORM\Column]
    private ?int $code_region = null;

    #[ORM\Column(length: 50)]
    private ?string $nom_region = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCommuneInsee(): ?int
    {
        return $this->code_commune_insee;
    }

    public function setCodeCommuneInsee(int $code_commune_insee): static
    {
        $this->code_commune_insee = $code_commune_insee;

        return $this;
    }

    public function getNomCommunePostal(): ?string
    {
        return $this->nom_commune_postal;
    }

    public function setNomCommunePostal(string $nom_commune_postal): static
    {
        $this->nom_commune_postal = $nom_commune_postal;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->code_postal;
    }

    public function setCodePostal(int $code_postal): static
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getLibelleAcheminement(): ?string
    {
        return $this->libelle_acheminement;
    }

    public function setLibelleAcheminement(string $libelle_acheminement): static
    {
        $this->libelle_acheminement = $libelle_acheminement;

        return $this;
    }

    public function getLigne5(): ?string
    {
        return $this->ligne_5;
    }

    public function setLigne5(?string $ligne_5): static
    {
        $this->ligne_5 = $ligne_5;

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
        return $this->code_commune;
    }

    public function setCodeCommune(int $code_commune): static
    {
        $this->code_commune = $code_commune;

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
        return $this->nom_commune;
    }

    public function setNomCommune(string $nom_commune): static
    {
        $this->nom_commune = $nom_commune;

        return $this;
    }

    public function getNomCommuneComplet(): ?string
    {
        return $this->nom_commune_complet;
    }

    public function setNomCommuneComplet(string $nom_commune_complet): static
    {
        $this->nom_commune_complet = $nom_commune_complet;

        return $this;
    }

    public function getCodeDepartement(): ?int
    {
        return $this->code_departement;
    }

    public function setCodeDepartement(int $code_departement): static
    {
        $this->code_departement = $code_departement;

        return $this;
    }

    public function getNomDepartement(): ?string
    {
        return $this->nom_departement;
    }

    public function setNomDepartement(string $nom_departement): static
    {
        $this->nom_departement = $nom_departement;

        return $this;
    }

    public function getCodeRegion(): ?int
    {
        return $this->code_region;
    }

    public function setCodeRegion(int $code_region): static
    {
        $this->code_region = $code_region;

        return $this;
    }

    public function getNomRegion(): ?string
    {
        return $this->nom_region;
    }

    public function setNomRegion(string $nom_region): static
    {
        $this->nom_region = $nom_region;

        return $this;
    }
}
