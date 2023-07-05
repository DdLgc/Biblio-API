<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['reservation:read']])]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['reservation:read', 'book:read'])]
    private ?int $id = null;
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reservation:read', 'book:read'])]
    private ?\DateTimeInterface $returnDateInitial = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['reservation:read', 'book:read'])]
    private ?\DateTimeInterface $loanDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['reservation:read'])]
    private ?\DateTimeInterface $reelReturnDate = null;

    #[ORM\ManyToMany(targetEntity: Book::class, inversedBy: 'reservations')]
    #[Groups(['reservation:read', 'user:read'])]
    private Collection $idBook;

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->idBook = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReturnDateInitial(): ?\DateTimeInterface
    {
        return $this->returnDateInitial;
    }

    public function setReturnDateInitial(\DateTimeInterface $returnDateInitial): self
    {
        $this->returnDateInitial = $returnDateInitial;

        return $this;
    }

    public function getLoanDate(): ?\DateTimeInterface
    {
        return $this->loanDate;
    }

    public function setLoanDate(\DateTimeInterface $loanDate): self
    {
        $this->loanDate = $loanDate;

        return $this;
    }

    public function getReelReturnDate(): ?\DateTimeInterface
    {
        return $this->reelReturnDate;
    }

    public function setReelReturnDate(?\DateTimeInterface $reelReturnDate): self
    {
        $this->reelReturnDate = $reelReturnDate;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getIdBook(): Collection
    {
        return $this->idBook;
    }

    public function addIdBook(Book $idBook): self
    {
        if (!$this->idBook->contains($idBook)) {
            $this->idBook->add($idBook);
        }

        return $this;
    }

    public function removeIdBook(Book $idBook): self
    {
        $this->idBook->removeElement($idBook);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
