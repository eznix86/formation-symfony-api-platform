<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BankAccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Controller\AddOperationController;

/**
 * @ApiResource(
 *     normalizationContext={
 *          "groups": {"bank_account:list"}
 *     },
 *     denormalizationContext={
 *          "groups": {"bank_account:write"}
 *     },
 *     collectionOperations={
 *      "GET",
 *      "POST": {
 *          "normalization_context": {
 *              "groups": {}
 *          },
 *          "validation_groups": {
 *              "bank_account:validation_create"
 *           },
 *          "denormalization_context": {
 *              "groups": {"bank_account:create"}
 *          },
 *      }
 *     },
 *     itemOperations={
 *     "post_operations": {
 *          "method": "POST",
 *          "path": "/bank_accounts/{id}/add-operation",
 *          "controller": AddOperationController::class,
 *          "normalization_context": {
 *              "groups": {"bank_operation:item"}
 *          },
 *
 *          "deserialize": false,
 *          "validate": false,
 *          "write": false
 *      },
 *     "GET": {
 *      "normalization_context": {
 *          "groups": {"bank_account:item", "bank_operation:item"}
 *      },
 *     },
 *     "PUT": {
 *         "security": "is_granted('UPDATE', object)",
 *          "denormalization_context": {
 *              "groups": {"bank_account:update", "bank_account:item"}
 *          },
 *     }}
 * )
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
 * @ApiFilter(filterClass=BooleanFilter::class, properties={"readonly"})
 * @ApiFilter(filterClass=DateFilter::class, properties={"created"})
 */
class BankAccount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"bank_account:item"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bank_account:item", "bank_account:write", "bank_account:create"})
     * @Assert\Iban(groups={"bank_account:validation_create"})
     */
    private $iban;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"bank_account:item", "bank_account:list", "bank_account:create"})
     */
    private $label;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"bank_account:item", "bank_account:write", "bank_account:create"})
     */
    private $readonly;

    /**
     * @Groups({"bank_account:create", "bank_account:update"})
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\OneToMany(targetEntity=BankOperation::class, mappedBy="bankAccount", orphanRemoval=true)
     * @Groups({"bank_account:item"})
     */
    private $bankOperations;

    public function __construct()
    {
        $this->bankOperations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIban(): ?string
    {
        return $this->iban;
    }

    public function setIban(string $iban): self
    {
        $this->iban = $iban;

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

    public function getReadonly(): ?bool
    {
        return $this->readonly;
    }

    public function setReadonly(bool $readonly): self
    {
        $this->readonly = $readonly;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return Collection|BankOperation[]
     */
    public function getBankOperations(): Collection
    {
        return $this->bankOperations;
    }

    public function addBankOperation(BankOperation $bankOperation): self
    {
        if (!$this->bankOperations->contains($bankOperation)) {
            $this->bankOperations[] = $bankOperation;
            $bankOperation->setBankAccount($this);
        }

        return $this;
    }

    public function removeBankOperation(BankOperation $bankOperation): self
    {
        if ($this->bankOperations->removeElement($bankOperation)) {
            // set the owning side to null (unless already changed)
            if ($bankOperation->getBankAccount() === $this) {
                $bankOperation->setBankAccount(null);
            }
        }

        return $this;
    }
}
