<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 128)]
    private string $name;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'roles')]
    #[ORM\JoinTable(name: "user_role")]
    private Collection $users;

    function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function addUser(User $user): Role
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addRole($this);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function jsonSerialize(): array
    {
        $arr = [
            'id' => $this->id,
            'name' => $this->name,
        ];
        return $arr;
    }

    public static function create(int $id, string $name): Role
    {
        $entity = new self();
        $entity->id = $id;
        $entity->name = $name;
        return $entity;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
