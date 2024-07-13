<?php

namespace App\Entity;

use App\Repository\EntityBRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntityBRepository::class)]
class EntityB implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: EntityA::class, inversedBy: "entitiesBs")]
    #[ORM\JoinColumn(name: "a_id", referencedColumnName: "id", nullable: false)]
    private EntityA $entityA;

    // ================================================================================================================
    public function jsonSerialize(): mixed
    {
        $jsonArray = [
            'id' => $this->id,
            'name' => $this->name,
            'entityA' => [
                'id' => $this->entityA->getId(),
                'name' => $this->entityA->getName()
            ],
        ];
        return $jsonArray;
    }

    // ================================================================================================================

    public static function create(string $name, EntityA $entityA): self
    {
        $entity = new self();
        $entity->setName($name);
        $entity->entityA = $entityA;
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
