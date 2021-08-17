<?php

namespace App\Entity;

use App\Repository\BankOperationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BankOperationRepository::class)
 */
class BankOperation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"bank_operation:item"})
     */
    private $amount;

    /**
     * @ORM\Column(type="date")
     * @Groups({"bank_operation:item"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bank_operation:item"})
     */
    private $label;

    /**
     * @ORM\ManyToOne(targetEntity=BankAccount::class, inversedBy="bankOperations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bankAccount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getBankAccount(): ?BankAccount
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?BankAccount $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }
}
