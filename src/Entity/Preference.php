<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\PreferenceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PreferenceRepository::class)]
#[ApiResource(
    description: 'Preferences of the users',
    operations: [
        new Get(uriTemplate: '/preference/{id}'), // Read
        new GetCollection(uriTemplate: '/preference/liste'), //Read
        new Post(uriTemplate: '/preference/ajout'), // create
        new Put(uriTemplate: '/preference/modification/{id}'),// replace (remplace toute les information même inchangé)
        new Patch(uriTemplate: '/preference/modification/{id}'), // update (regarde les informations déjà rentré et change cell qui sont différentes)
        new Delete(uriTemplate: '/preference/suppression/{id}') // delete
    ]
)]
class Preference
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 56)]
    private ?string $typepreference = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\OneToOne(inversedBy: 'preference')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateurpref = null;

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

    public function getUtilisateurpref(): ?Utilisateur
    {
        return $this->utilisateurpref;
    }

    public function setUtilisateurpref(Utilisateur $utilisateurpref): static
    {
        $this->utilisateurpref = $utilisateurpref;

        return $this;
    }
}
