<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\DiscussionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DiscussionRepository::class)]
#[ApiResource(
    description: 'Messages betwin users',
    operations: [
        new Get(uriTemplate: '/discussion/{id}'), // Read
        new GetCollection(uriTemplate: '/discussion/liste'), //Read
        new Post(uriTemplate: '/discussion/ajout'), // create
        new Put(uriTemplate: '/discussion/modification/{id}'),// replace (remplace toute les information même inchangé)
        new Patch(uriTemplate: '/discussion/modification/{id}'), // update (regarde les informations déjà rentré et change cell qui sont différentes)
        new Delete(uriTemplate: '/discussion/suppression/{id}') // delete
    ]
)]
class Discussion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idemmeteur = null;

    #[ORM\ManyToOne(inversedBy: 'discussions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $idrecepteur = null;

    #[ORM\Column(length: 500)]
    private ?string $contenu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEmmeteur(): ?Utilisateur
    {
        return $this->idemmeteur;
    }

    public function setIdEmmeteur(?Utilisateur $idemmeteur): static
    {
        $this->idemmeteur = $idemmeteur;

        return $this;
    }

    public function getIdRecepteur(): ?Utilisateur
    {
        return $this->idrecepteur;
    }

    public function setIdRecepteur(?Utilisateur $idrecepteur): static
    {
        $this->idrecepteur = $idrecepteur;

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
