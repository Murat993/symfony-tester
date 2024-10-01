<?php

namespace App\Model\User\Entity;


use App\Repository\User\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User implements UserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: "uuid", unique: true)]
    private Uuid $id;

    #[ORM\Column(type: "string", length: 180, unique: true)]
    private string $username;

    public function __construct(string $username)
    {
        $this->id = Uuid::v4();
        $this->username = $username;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}