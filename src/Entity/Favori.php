<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FavoriRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FavoriRepository::class)]
#[ApiResource(
    description: 'Favorites of the users',
    operations: [
        new Get(uriTemplate: '/favori/{id}'), // Read
        new GetCollection(uriTemplate: '/favori/liste'), //Read
        new Post(uriTemplate: '/favori/ajout'), // create
        new Put(uriTemplate: '/favori/modification/{id}'),// replace (remplace toute les information même inchangé)
        new Patch(uriTemplate: '/favori/modification/{id}'), // update (regarde les informations déjà rentré et change cell qui sont différentes)
        new Delete(uriTemplate: '/favori/suppression/{id}') // delete
    ]
)]
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
    private ?favori $idfavori = null;

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

    public function getIdfavori(): ?favori
    {
        return $this->idfavori;
    }

    public function setIdfavori(?favori $idfavori): static
    {
        $this->idfavori = $idfavori;

        return $this;
    }
}
