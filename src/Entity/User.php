<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Email must be at least {{ limit }} characters long for {{ value }}',
        maxMessage: 'Email cannot be longer than {{ limit }} characters fro {{ value }}',
    )]
    #[ORM\Column(length: 255, unique: true, nullable: false)]
    private string $email;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'Name must be at least {{ limit }} characters long for {{ value }}',
        maxMessage: 'Name cannot be longer than {{ limit }} characters for {{ value }}',
    )]
    #[ORM\Column(length: 255, nullable: false)]
    private string $name;

    #[ORM\OneToOne(inversedBy: 'giveTo', targetEntity: self::class, cascade: ['persist'])]
    private ?self $giveTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = strtolower($email);

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = ucfirst($name);

        return $this;
    }

    public function getGiveTo(): ?self
    {
        return $this->giveTo;
    }

    public function setGiveTo(?self $giveTo): self
    {
        $this->giveTo = $giveTo;

        return $this;
    }
}
