<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var int
     *
     * @ORM\Column(name="idProduit", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idproduit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="nom_produit", type="string", length=50, nullable=true)
     */
    private $nomProduit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="tarif_produit", type="integer", nullable=true)
     */
    private $tarifProduit;

    /**
     * @var int|null
     *
     * @ORM\Column(name="stock", type="integer", nullable=true)
     */
    private $stock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="libelle", type="text", length=10000, nullable=true)
     */
    private $libelle;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_apparition", type="datetime", nullable=true)
     */
    private $dateApparition;

    /**
     *
     * @ORM\Column(name="image", type="string", length=0, nullable=true)
     */
    private $image;

    private $rawImage;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class)
     * @ORM\JoinColumn(name="Id_Categorie", referencedColumnName="Id_Categorie", onDelete="CASCADE")
     */
    private $id_categorie;

    /**
     * @ORM\OneToMany(targetEntity=LigneCommande::class, mappedBy="id_produit")
     */
    private $ligneCommandes;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function afficherImage()
    {
        if(null === $this->rawImage) {
            $this->rawImage = "data:image/png;base64," . base64_encode(stream_get_contents($this->getImage()));
        }

        return $this->rawImage;
    }

    public function getIdproduit(): ?int
    {
        return $this->idproduit;
    }

    public function getNomProduit(): ?string
    {
        return $this->nomProduit;
    }

    public function setNomProduit(?string $nomProduit): self
    {
        $this->nomProduit = $nomProduit;

        return $this;
    }

    public function getTarifProduit(): ?int
    {
        return $this->tarifProduit;
    }

    public function setTarifProduit(?int $tarifProduit): self
    {
        $this->tarifProduit = $tarifProduit;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(?string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDateApparition(): ?\DateTimeInterface
    {
        return $this->dateApparition;
    }

    public function setDateApparition(?\DateTimeInterface $dateApparition): self
    {
        $this->dateApparition = $dateApparition;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->id_categorie;
    }

    public function setIdCategorie(?Categorie $id_categorie): self
    {
        $this->id_categorie = $id_categorie;

        return $this;
    }




    /**
     * @return Collection|LigneCommande[]
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setIdProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getIdProduit() === $this) {
                $ligneCommande->setIdProduit(null);
            }
        }

        return $this;
    }


}
