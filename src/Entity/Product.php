<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 */
class Product
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
    private $name;

    /**
     * @Assert\DateTime
     */
    private $datetime;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @Assert\DateTime
     */
    private $date_fin_garantie;

    /**
     * @ORM\Column(type="text")
     */
    private $commentaires;

    /**
     * @ORM\Column(type="boolean")
     */
    private $manuel;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="category_id",cascade={"persist"})
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateFinGarantie(): ?\DateTimeInterface
    {
        return $this->date_fin_garantie;
    }

    public function setDateFinGarantie(\DateTimeInterface $date_fin_garantie): self
    {
        $this->date_fin_garantie = $date_fin_garantie;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getManuel(): ?bool
    {
        return $this->manuel;
    }

    public function setManuel(bool $manuel): self
    {
        $this->manuel = $manuel;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }
}
