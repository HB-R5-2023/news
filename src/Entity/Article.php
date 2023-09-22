<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 200)]
  private ?string $title = null;

  #[ORM\Column(type: Types::TEXT)]
  private ?string $content = null;

  #[ORM\Column]
  private ?bool $visible = null;

  #[ORM\Column(type: Types::DATE_MUTABLE)]
  private ?\DateTimeInterface $dateCreated = null;

  #[ORM\ManyToOne(inversedBy: 'articles')]
  private ?Category $category = null;

  #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'articles')]
  private Collection $tags;

  public function __construct()
  {
      $this->tags = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getTitle(): ?string
  {
    return $this->title;
  }

  public function setTitle(string $title): static
  {
    $this->title = $title;

    return $this;
  }

  public function getContent(): ?string
  {
    return $this->content;
  }

  public function setContent(string $content): static
  {
    $this->content = $content;

    return $this;
  }

  public function isVisible(): ?bool
  {
    return $this->visible;
  }

  public function setVisible(bool $visible): static
  {
    $this->visible = $visible;

    return $this;
  }

  public function getDateCreated(): ?\DateTimeInterface
  {
    return $this->dateCreated;
  }

  public function setDateCreated(\DateTimeInterface $dateCreated): static
  {
    $this->dateCreated = $dateCreated;

    return $this;
  }

  public function getCategory(): ?Category
  {
    return $this->category;
  }

  public function setCategory(?Category $category): static
  {
    $this->category = $category;

    return $this;
  }

  /**
   * @return Collection<int, Tag>
   */
  public function getTags(): Collection
  {
      return $this->tags;
  }

  public function addTag(Tag $tag): static
  {
      if (!$this->tags->contains($tag)) {
          $this->tags->add($tag);
          $tag->addArticle($this);
      }

      return $this;
  }

  public function removeTag(Tag $tag): static
  {
      if ($this->tags->removeElement($tag)) {
          $tag->removeArticle($this);
      }

      return $this;
  }
}
