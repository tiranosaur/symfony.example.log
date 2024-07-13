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

    #[ORM\OneToMany(targetEntity: EntityB::class, mappedBy: 'entityA')]
    private Collection $entitiesBs;

    // ================================================================================================================

    public function addEntityB(EntityB $entityB): void
    {
        $this->entitiesBs[] = $entityB;
    }

    public function removeEntityB(EntityB $entityB): void
    {
        $this->entitiesBs->removeElement($entityB);
    }

    public function jsonSerialize(): mixed
    {
        $jsonArray = [
            'id' => $this->id,
            'name' => $this->name,
            'entitiesBs' => [],
        ];

        foreach ($this->entitiesBs as $item) {
            $jsonArray['entitiesBs'][] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
            ];
        }

        return $jsonArray;
    }

    function __construct()
    {
        $this->entitiesBs = new ArrayCollection();
    }

    // ================================================================================================================

    public static function create(string $name): self
    {
        $entity = new self();
        $entity->setName($name);
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
