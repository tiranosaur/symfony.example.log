<?php

namespace App\Entity;

use App\Repository\EntityARepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: EntityARepository::class)]
class EntityA implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: EntityB::class, inversedBy: 'entityAs')]
    #[ORM\JoinTable(name: "entityA_entityB")]
    private Collection $entityBs;

    // ========== many to many ====================================================================================
    public function getEntityBs(): Collection
    {
        return $this->entityBs;
    }

    public function addEntityB(EntityB $entityB): self
    {
        if (!$this->entityBs->contains($entityB)) {
            $this->entityBs[] = $entityB;
            $entityB->addEntityA($this);
        }

        return $this;
    }

    public function removeEntityB(EntityB $entityB): self
    {
        if ($this->entityBs->removeElement($entityB)) {
            $entityB->removeEntityA($this);
        }

        return $this;
    }

    // JSON
    public function jsonSerialize(): array
    {
        $jsonArray = [
            'id' => $this->id,
            'name' => $this->name,
            'entityBs' => []
        ];

        foreach ($this->entityBs as $entityB) {
            $jsonArray['entityBs'][] = [
                'id' => $entityB->getId(),
                'name' => $entityB->getName(),
            ];
        }

        return $jsonArray;
    }

    public function __construct()
    {
        $this->entityBs = new ArrayCollection();
    }

    // ============================================================================================================

    public static function create(string $name): EntityA
    {
        $entity = new self();
        $entity->setName($name);
        $entity->entityBs = new ArrayCollection();
        return $entity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
