<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SearchRepository;
use Symfony\Component\Validator\Constraints as Assert;




#[ORM\Entity(repositoryClass: SearchRepository::class)]
class Search
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'searches', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Searcher $searcher = null;

    #[Assert\NotBlank(message: 'Vous devez renseigner un prénom')]
    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstName = null;

    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: 'Vous devez renseigner un âge, même approximatif')]
    #[Assert\Length(max: 3, maxMessage: '3 caractères maximum')]
    #[ORM\Column]
    private ?string $age = null;

    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cityFirstTime = null;

    #[Assert\Length(max: 200, maxMessage: '200 caractères maximum')]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cityLastTime = null;

    #[Assert\Length(max: 2000, maxMessage: 'Le message ne doit pas dépasser 2000 caractères')]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearcher(): ?Searcher
    {
        return $this->searcher;
    }

    public function setSearcher(?Searcher $searcher): self
    {
        $this->searcher = $searcher;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCityFirstTime(): ?string
    {
        return $this->cityFirstTime;
    }

    public function setCityFirstTime(?string $cityFirstTime): self
    {
        $this->cityFirstTime = $cityFirstTime;

        return $this;
    }

    public function getCityLastTime(): ?string
    {
        return $this->cityLastTime;
    }

    public function setCityLastTime(?string $cityLastTime): self
    {
        $this->cityLastTime = $cityLastTime;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

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

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }
}
