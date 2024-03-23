<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert; 

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ApiResource(
    description: 'Account of the users',
    // normalizationContext: ['groups' => ['user:read']],
    // denormalizationContext: ['groups' => ['user:write']],
    operations: [
        new GetCollection(uriTemplate: '/admin/compte/liste'), //Read list
        new Post(uriTemplate: '/inscription'), // Create
        new Put(uriTemplate: '/compte/modification/{id}'),// Replace (remplace toute les information même inchangé)
        new Delete(uriTemplate: '/compte/suppression/{id}') // Delete
    ]
)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    // #[Groups(['user:read', 'user:write'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datedenaissance = null;


    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Length(min : 5)]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $photodeprofil = null;

    #[ORM\Column]
    private array $roles = [];
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datedecreationducompte = null;

    #[ORM\OneToMany(mappedBy: 'idutilisateur', targetEntity: Preference::class)]
    private Collection $preferences;

    #[ORM\OneToMany(mappedBy: 'idemmeteur', targetEntity: Discussion::class)]
    private Collection $discussions;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Favori::class)]
    private Collection $favoris;



    public function __construct()
    {
        $this->preferences = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateDeNaissance(): ?\DateTimeInterface
    {
        return $this->datedenaissance;
    }

    public function setDateDeNaissance(\DateTimeInterface $datedenaissance): static
    {
        $this->datedenaissance = $datedenaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPhotoDeProfil(): ?string
    {
        return $this->photodeprofil;
    }

    public function setPhotoDeProfil(?string $photodeprofil): static
    {
        $this->photodeprofil = $photodeprofil;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getDateDeCreationDuCompte(): ?\DateTimeInterface
    {
        return $this->datedecreationducompte;
    }

    public function setDateDeCreationDuCompte(\DateTimeInterface $datedecreationducompte): static
    {
        $this->datedecreationducompte = $datedecreationducompte;

        return $this;
    }

    /**
     * @return Collection<int, Preference>
     */
    public function getPreferences(): Collection
    {
        return $this->preferences;
    }

    public function addPreference(Preference $preference): static
    {
        if (!$this->preferences->contains($preference)) {
            $this->preferences->add($preference);
            $preference->setUtilisateur($this);
        }

        return $this;
    }

    public function removePreference(Preference $preference): static
    {
        if ($this->preferences->removeElement($preference)) {
            // set the owning side to null (unless already changed)
            if ($preference->getUtilisateur() === $this) {
                $preference->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): static
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions->add($discussion);
            $discussion->setIdEmmeteur($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getIdEmmeteur() === $this) {
                $discussion->setIdEmmeteur(null);
            }
        }

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
            $favoris->setUtilisateur($this);
        }

        return $this;
    }

    public function removeFavoris(Favori $favoris): static
    {
        if ($this->favoris->removeElement($favoris)) {
            // set the owning side to null (unless already changed)
            if ($favoris->getUtilisateur() === $this) {
                $favoris->setUtilisateur(null);
            }
        }

        return $this;
    }
}
