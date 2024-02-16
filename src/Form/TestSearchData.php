<?php

namespace App\Form;

use App\Repository\TestSearchDataRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TestSearchDataRepository::class)]
class TestSearchData
{
    public ?int $id = null;

    #[Assert\NotBlank()]
    public ?string $searchFirstName = null;

    public ?string $searchLastName = null;

    #[Assert\NotBlank()]
    public ?string $searchAge = null;

    public ?string $searchCityFirst = null;

    public ?string $searchCityLast = null;

    #[Assert\NotBlank()]
    public ?string $myFirstName = null;

    #[Assert\NotBlank()]
    public ?string $myLastName = null;

    #[Assert\NotBlank()]
    public ?string $myBirthYear = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchFirstName(): ?string
    {
        return $this->searchFirstName;
    }

    public function setSearchFirstName(string $searchFirstName): self
    {
        $this->searchFirstName = $searchFirstName;

        return $this;
    }

    public function getSearchLastName(): ?string
    {
        return $this->searchLastName;
    }

    public function setSearchLastName(?string $searchLastName): self
    {
        $this->searchLastName = $searchLastName;

        return $this;
    }

    public function getSearchAge(): ?string
    {
        return $this->searchAge;
    }

    public function setSearchAge(string $searchAge): self
    {
        $this->searchAge = $searchAge;

        return $this;
    }

    public function getSearchCityFirst(): ?string
    {
        return $this->searchCityFirst;
    }

    public function setSearchCityFirst(?string $searchCityFirst): self
    {
        $this->searchCityFirst = $searchCityFirst;

        return $this;
    }

    public function getSearchCityLast(): ?string
    {
        return $this->searchCityLast;
    }

    public function setSearchCityLast(?string $searchCityLast): self
    {
        $this->searchCityLast = $searchCityLast;

        return $this;
    }

    public function getMyFirstName(): ?string
    {
        return $this->myFirstName;
    }

    public function setMyFirstName(string $myFirstName): self
    {
        $this->myFirstName = $myFirstName;

        return $this;
    }

    public function getMyLastName(): ?string
    {
        return $this->myLastName;
    }

    public function setMyLastName(string $myLastName): self
    {
        $this->myLastName = $myLastName;

        return $this;
    }

    public function getMyBirthYear(): ?string
    {
        return $this->myBirthYear;
    }

    public function setMyBirthYear(string $myBirthYear): self
    {
        $this->myBirthYear = $myBirthYear;

        return $this;
    }
}
