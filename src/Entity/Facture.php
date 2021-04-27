<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity
 */
class Facture
{
    /**
     * @var int
     *
     * @ORM\Column(name="Id_Facture", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFacture;

    /**
     * @var string|null
     *
     * @ORM\Column(name="numero_facture", type="string", length=255, nullable=true)
     */
    private $numeroFacture;

    /**
     * @var int
     *
     * @ORM\Column(name="montant_facture", type="integer", nullable=false)
     */
    private $montantFacture;

    /**
     * @var string
     *
     * @ORM\Column(name="facture_pdf", type="blob", length=65535, nullable=false)
     */
    private $facturePdf;

    /**
     * @var string
     */
    private $readPdf;

    public function readPdf()
    {
        if(null === $this->readPdf) {
            $this->readPdf = "data:application/pdf;base64," . base64_encode(stream_get_contents($this->getFacturePdf()));
        }

        return $this->readPdf;
    }

    public function getIdFacture(): ?int
    {
        return $this->idFacture;
    }

    public function getNumeroFacture(): ?string
    {
        return $this->numeroFacture;
    }

    public function setNumeroFacture(?string $numeroFacture): self
    {
        $this->numeroFacture = $numeroFacture;

        return $this;
    }

    public function getMontantFacture(): ?int
    {
        return $this->montantFacture;
    }

    public function setMontantFacture(int $montantFacture): self
    {
        $this->montantFacture = $montantFacture;

        return $this;
    }

    public function getFacturePdf()
    {
        return $this->facturePdf;
    }

    public function setFacturePdf($facturePdf): self
    {
        $this->facturePdf = $facturePdf;

        return $this;
    }


}
