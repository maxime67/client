<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\ManyToMany(targetEntity=Societe::class, inversedBy="clients")
     */
    private $societe;

    /**
     * @ORM\OneToMany(targetEntity=Rdv::class, mappedBy="client")
     */
    private $rdv;

    public function __construct()
    {
        $this->societe = new ArrayCollection();
        $this->rdv = new ArrayCollection();
    }

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection<int, societe>
     */
    public function getSociete(): Collection
    {
        return $this->societe;
    }

    public function addSociete(societe $societe): self
    {
        if (!$this->societe->contains($societe)) {
            $this->societe[] = $societe;
        }

        return $this;
    }

    public function removeSociete(societe $societe): self
    {
        $this->societe->removeElement($societe);

        return $this;
    }

    /**
     * @return Collection<int, rdv>
     */
    public function getRdv(): Collection
    {
        return $this->rdv;
    }

    public function addRdv(rdv $rdv): self
    {
        if (!$this->rdv->contains($rdv)) {
            $this->rdv[] = $rdv;
            $rdv->setClient($this);
        }

        return $this;
    }

    public function removeRdv(rdv $rdv): self
    {
        if ($this->rdv->removeElement($rdv)) {
            // set the owning side to null (unless already changed)
            if ($rdv->getClient() === $this) {
                $rdv->setClient(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getNom().$this->getPrenom();
    }

}
