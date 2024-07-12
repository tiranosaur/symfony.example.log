<?php declare(strict_types=1);

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::STRING, length: 128)]
    private ?string $author = 'default_value';

    #[ORM\Column(type: Types::STRING, length: 128, nullable: true)]
    private ?string $title;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private string $content;

    #[ORM\Column(type: Types::FLOAT)]
    #[Assert\Type(type: 'float')]
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(value: 99.99)]
    #[Assert\GreaterThanOrEqual(value: 0.01)]
    private float $price;



    public static function create(int|null $id, string|null $author, string $title, string $content, float $price): Article
    {
        $article = new self();
        $article->id = $id;
        $article->author = $author ?? $article->author;
        $article->title = $title;
        $article->content = $content;
        $article->price = $price;
        return $article;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'author' => $this->author,
            'title' => $this->title,
            'content' => $this->content,
            'price' => $this->price,
        ];
    }

    public function getId(): ?int
    {
        return $this->id;
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
