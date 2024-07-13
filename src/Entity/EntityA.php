<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\EntityARepository;
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

    #[ORM\Column(type: Types::STRING)]
    public ?string $name = null;

    #[ORM\OneToOne(targetEntity: EntityB::class, mappedBy: 'entityA')]
    public ?EntityB $entityB = null;

    public static function create(string $name): EntityA
    {
        $entity = new self();
        $entity->name = $name;
        return $entity;
    }

    public function jsonSerialize(): array
    {
        $arr = [
            'id' => $this->id,
            'name' => $this->name,
        ];

        if ($this->entityB) {
            $arr['entityB'] = [
                'id' => $this->entityB->getId(),
                'name' => $this->entityB->getName(),
            ];
        }

        return $arr;
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
