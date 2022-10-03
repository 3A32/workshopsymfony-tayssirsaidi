<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\Column(length: 255)]
    private ?string $Ref = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    public function getRef(): ?string
    {
        return $this->ref;
    }

    

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }
}
