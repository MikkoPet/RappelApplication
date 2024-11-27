<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    /**
     * @var Collection<int, Rappel>
     */
    #[ORM\OneToMany(targetEntity: Rappel::class, mappedBy: 'Categorie')]
    private Collection $rappels;

    public function __construct()
    {
        $this->rappels = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    /**
     * @return Collection<int, Rappel>
     */
    public function getRappels(): Collection
    {
        return $this->rappels;
    }

    public function addRappel(Rappel $rappel): static
    {
        if (!$this->rappels->contains($rappel)) {
            $this->rappels->add($rappel);
            $rappel->setCategorie($this);
        }

        return $this;
    }

    public function removeRappel(Rappel $rappel): static
    {
        if ($this->rappels->removeElement($rappel)) {
            // set the owning side to null (unless already changed)
            if ($rappel->getCategorie() === $this) {
                $rappel->setCategorie(null);
            }
        }

        return $this;
    }
}
