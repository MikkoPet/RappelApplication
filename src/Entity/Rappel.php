<?php

namespace App\Entity;

use App\Repository\RappelRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[Gedmo\SoftDeleteable(fieldName: "deletedAt", timeAware: false, hardDelete: false)]
#[ORM\Entity(repositoryClass: RappelRepository::class)]
class Rappel
{
    use SoftDeleteableEntity;
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $DateRappel = null;

    #[ORM\Column]
    private ?bool $estFait = false;

    #[ORM\ManyToOne(inversedBy: 'rappels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $Categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

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

    public function getDateRappel(): ?\DateTimeInterface
    {
        return $this->DateRappel;
    }

    public function setDateRappel(\DateTimeInterface $DateRappel): static
    {
        $this->DateRappel = $DateRappel;

        return $this;
    }

    public function isEstFait(): ?bool
    {
        return $this->estFait;
    }

    public function setEstFait(bool $estFait): static
    {
        $this->estFait = $estFait;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->Categorie;
    }

    public function setCategorie(?Categorie $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }
}
