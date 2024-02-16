<?php

namespace App\Entity;

use App\Repository\SearcherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;




#[ORM\Entity(repositoryClass: SearcherRepository::class)]
class Searcher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Vous devez renseigner votre prénom')]
    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    
    #[Assert\NotBlank(message: 'Vous devez renseigner votre nom')]
    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: 'Vous devez renseigner votre année de naissance')]
    #[Assert\Length(max: 4, maxMessage: '4 caractères maximum')]
    #[ORM\Column]
    private ?string $birthYear = null;

    #[Assert\NotBlank(message: 'Vous devez renseigner votre adresse email')]
    #[Assert\Email(message: 'Adresse email invalide')]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\Length(max: 14, maxMessage: 'Numéro de téléphone invalide')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'searcher', targetEntity: Search::class)]
    private Collection $searches;

    #[Assert\IsTrue(message: 'Vous devez cocher cette case')]
    #[ORM\Column]
    private ?bool $consent = null;

    public function __construct()
    {
        $this->searches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthYear(): ?string
    {
        return $this->birthYear;
    }

    public function setBirthYear(string $birthYear): self
    {
        $this->birthYear = $birthYear;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, Search>
     */
    public function getSearches(): Collection
    {
        return $this->searches;
    }

    public function addSearch(Search $search): self
    {
        if (!$this->searches->contains($search)) {
            $this->searches->add($search);
            $search->setSearcher($this);
        }

        return $this;
    }

    public function removeSearch(Search $search): self
    {
        if ($this->searches->removeElement($search)) {
            // set the owning side to null (unless already changed)
            if ($search->getSearcher() === $this) {
                $search->setSearcher(null);
            }
        }

        return $this;
    }

    public function isConsent(): ?bool
    {
        return $this->consent;
    }

    public function setConsent(bool $consent): self
    {
        $this->consent = $consent;

        return $this;
    }
}
