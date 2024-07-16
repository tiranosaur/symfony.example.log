<?php

namespace App\Entity;

use App\Repository\UserRepository;
use App\Util\UserRoleUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'users')]
    private Collection $roles;

    function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getRoles(): array
    {
        $roles = [];
        foreach ($this->roles->toArray() as $item) {
            $roles[] = $item->getName();
        }

        UserRoleUtil::adminHandlig($roles);

        return array_unique($roles);
    }


    public function addRole(Role $role): User
    {
        if (!$this->roles->contains($role)) {
            $this->roles[] = $role;
            $role->addUser($this);
        }

        return $this;
    }

    public static function create(int|null $id, string $username, string $password): self
    {
        $entity = new self();
        $entity->id = $id;
        $entity->setUsername($username);
        $entity->setPassword(password_hash($password, PASSWORD_BCRYPT));
        return $entity;
    }

    public function jsonSerialize(): array
    {
        $arr = [
            'id' => $this->id,
            'name' => $this->username,
            'roles' => [],
        ];
//        foreach ($this->roles as $role) {
//            $arr['roles'][] = $role->getName();
//        }
        return $arr;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
