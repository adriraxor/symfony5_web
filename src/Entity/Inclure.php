<?php

namespace App\Entity;

use App\Repository\InclureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InclureRepository::class)
 */
class Inclure
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(name="idProduit", referencedColumnName="idProduit")
     */
    private $id_produit;

    /**
     * @ORM\ManyToOne(targetEntity=Panier::class)
     * @ORM\JoinColumn(name="id_panier", referencedColumnName="id")
     */
    private $id_panier;

    public function __construct()
    {
        $this->id_produit = new ArrayCollection();
        $this->id_panier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getIdProduit(): Collection
    {
        return $this->id_produit;
    }

    public function setIdProduit(?produit $id_produit): self
    {
        $this->id_produit = $id_produit;

        return $this;
    }

    /**
     * @return Collection|Panier[]
     */
    public function getIdPanier(): Collection
    {
        return $this->id_panier;
    }

    public function setIdPanier(?panier $id_panier): self
    {
        $this->id_panier = $id_panier;

        return $this;
    }
}
