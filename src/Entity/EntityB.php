<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\EntityBRepository;
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

    #[ORM\Column(type: Types::STRING)]
    public ?string $name = null;

    #[ORM\OneToOne(targetEntity: EntityA::class, inversedBy: 'entityB')]
    #[ORM\JoinColumn(name: "a_id", referencedColumnName: "id")]
    public ?EntityA $entityA = null;

    public static function create(string $name, ?EntityA $entityA): EntityB
    {
        $entity = new self();
        $entity->name = $name;
        $entity->entityA = $entityA;
        return $entity;
    }

    public function jsonSerialize(): array
    {
        $arr = [
            'id' => $this->id,
            'name' => $this->name,

        ];

        if ($this->entityA) {
            $arr['entityB'] = [
                'id' => $this->entityA->getId(),
                'name' => $this->entityA->getName(),
            ];
        }
        return $arr;
    }

    public function setEntityA(?EntityA $entityA): void
    {
        $this->entityA = $entityA;
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