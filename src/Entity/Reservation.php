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

    #[ORM\ManyToOne(inversedBy: 'reservation')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['reservation:read'])]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: Book::class)]
    private Collection $book;

    public function __construct()
    {
        $this->book = new ArrayCollection();
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Book $book): self
    {
        if (!$this->book->contains($book)) {
            $this->book->add($book);
            $book->setReservation($this);
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        if ($this->book->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getReservation() === $this) {
                $book->setReservation(null);
            }
        }

        return $this;
    }

}
