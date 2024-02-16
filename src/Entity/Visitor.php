<?php

namespace App\Entity;

use App\Repository\VisitorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorRepository::class)]
class Visitor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $token = null;

    #[ORM\OneToMany(mappedBy: 'visitor', targetEntity: Visit::class)]
    private Collection $visits;

    #[ORM\Column]
    private ?bool $tracked = false;

    public function __construct()
    {
        $this->visits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Visit>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setVisitor($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->removeElement($visit)) {
            // set the owning side to null (unless already changed)
            if ($visit->getVisitor() === $this) {
                $visit->setVisitor(null);
            }
        }

        return $this;
    }

    public function isTracked(): ?bool
    {
        return $this->tracked;
    }

    public function setTracked(bool $tracked): self
    {
        $this->tracked = $tracked;

        return $this;
    }
}
