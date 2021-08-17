<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BankAccountRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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
 *     "GET": {
 *      "normalization_context": {
 *          "groups": {"bank_account:item"}
 *      },
 *     },
 *     "PUT": {
 *      "validation_groups": {
 *          "bank_account:validation_create"
 *      }
 * }}
 * )
 * @ORM\Entity(repositoryClass=BankAccountRepository::class)
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
}
