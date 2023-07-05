<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['book:read']])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['book:read', 'reservation:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'reservation:read', 'user:read'])]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read', 'reservation:read'])]
    private ?string $autor = null;

    #[ORM\Column(length: 255)]
    private ?string $isbn = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['book:read'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $PublishingDate = null;

    #[ORM\Column]
    #[Groups(['book:read'])]
    private ?bool $isReserved = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:read'])]
    private ?string $url = null;


    #[ORM\ManyToMany(targetEntity: Reservation::class, mappedBy: 'idBook')]
    #[Groups(['book:read'])]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPublishingDate(): ?\DateTimeInterface
    {
        return $this->PublishingDate;
    }

    public function setPublishingDate(\DateTimeInterface $PublishingDate): self
    {
        $this->PublishingDate = $PublishingDate;

        return $this;
    }

    public function isIsReserved(): ?bool
    {
        return $this->isReserved;
    }

    public function setIsReserved(bool $isReserved): self
    {
        $this->isReserved = $isReserved;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->addIdBook($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            $reservation->removeIdBook($this);
        }

        return $this;
    }


}
