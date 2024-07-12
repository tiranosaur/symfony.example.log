<?php declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Article
{
    #[Assert\NotBlank(message: " --- Id SHOULD NOT BE BLANK. --- ")]
    #[Assert\Type(type: 'integer', message: "The value {{ value }} is not a valid {{ type }}.")]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Author is blank.")]
    private ?string $author = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 10,
        minMessage: "Title must be at least {{ limit }} characters long",
        maxMessage: "Title cannot be longer than {{ limit }} characters"
    )]
    private ?string $title = null;

    #[Assert\Regex(
        pattern: "/^[^\d]*$/",
        message: "=== CONTENT CAN ONLY CONTAIN LETTERS ==="
    )]
    #[Assert\Regex(
        pattern: "/^[A-Z]*$/",
        message: "=== CONTENT CAN ONLY CONTAIN UPPERCASE LETTERS ==="
    )]
    private ?string $content = null;

    #[Assert\Type(type: 'float')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(value: 99.99, message: "Greater than or equal to {{ compared_value }}")]
    #[Assert\GreaterThanOrEqual(value: 0.01)]
    private float $price;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): void
    {
        $this->author = $author;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}
