<?php

namespace App\Entity;

use App\Repository\EntityBRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: EntityBRepository::class)]
class EntityB implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: EntityA::class, mappedBy: 'entityBs')]
    private Collection $entityAs;

    // ========== many to many ====================================================================================
    public function getEntityAs(): Collection
    {
        return $this->entityAs;
    }

    public function addEntityA(EntityA $entityA): self
    {
        if (!$this->entityAs->contains($entityA)) {
            $this->entityAs[] = $entityA;
            $entityA->addEntityB($this);
        }

        return $this;
    }

    public function removeEntityA(EntityA $entityA): self
    {
        if ($this->entityAs->removeElement($entityA)) {
            $entityA->removeEntityB($this);
        }

        return $this;
    }

    // JSON
    public function JsonSerialize(): array
    {
        $jsonArray = [
            'id' => $this->id,
            'name' => $this->name,
            'entityA' => [],
        ];

        foreach ($this->entityAs as $entityA) {
            $jsonArray['entityA'][] = [
                'id' => $entityA->getId(),
                'name' => $entityA->getName(),
            ];
        }

        return $jsonArray;
    }

    public function __construct()
    {
        $this->entityAs = new ArrayCollection();
    }

    // ============================================================================================================

    public static function create(string $name): EntityB
    {
        $entity = new self();
        $entity->setName($name);
        $entity->entityAs = new ArrayCollection();
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
