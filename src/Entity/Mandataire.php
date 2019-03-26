<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MandataireRepository")
 */
class Mandataire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fonction;

    /**
     * @ORM\ManyToOne(targetEntity="Annonces", inversedBy="mandataires")
     */
    private $Annonces;


    /**
     * @ORM\ManyToOne(targetEntity="MandatairesTest")
     */
    private $MandataireTrouve;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getAnnonces(): ?Annonces
    {
        return $this->Annonces;
    }

    public function setAnnonces(?Annonces $Annonces): self
    {
        $this->Annonces = $Annonces;

        return $this;
    }

    public function getMandataireTrouve(): ?MandatairesTest
    {
        return $this->MandataireTrouve;
    }

    public function setMandataireTrouve(?MandatairesTest $MandataireTrouve): self
    {
        $this->MandataireTrouve = $MandataireTrouve;

        return $this;
    }
}
