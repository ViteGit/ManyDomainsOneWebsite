<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

abstract class Post
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string | null
     *
     * @ORM\Column(name="title_ru", type="string", nullable=true)
     */
    protected $titleRu;

    /**
     * @var string | null
     *
     * @ORM\Column(name="keywords", type="string", length=1000, nullable=true)
     */
    protected $keywords;

    /**
     * @var string | null
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var int
     *
     * @ORM\Column(name="counter", type="integer", options={"default" : 0})
     */
    protected $counter = 0;

    /**
     * @ORM\Column(name="active", type="boolean", options={"default" : false})
     */
    protected $active = 0;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="create_at", type="datetime_immutable", nullable=true)
     */
    protected $createAt;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="update_at", type="datetime_immutable", nullable=true)
     */
    protected $updateAt;

    /**
     * @var string | null
     *
     * @ORM\Column(name="slug", type="string", nullable=true)
     */
    protected $slug;

    /**
     * @var string | null
     *
     * @ORM\Column(name="meta_title", type="string", nullable=true)
     */
    protected $metaTitle;

    /**
     * @var string | null
     *
     * @ORM\Column(name="meta_description", type="string", nullable=true)
     */
    protected $metaDescription;

    /**
     * @var string | null
     *
     * @ORM\Column(name="referrer_counter", type="integer", nullable=true)
     */
    protected $referrerCounter;

    /**
     * @param string $title
     * @param string $titleRu | null
     * @param string $slug
     * @param string | null $keywords
     * @param string | null $description
     * @param bool $active
     * @param string | null $metaTitle
     * @param string | null $metaDescription
     * @throws Exception
     */
    public function __construct(
        string $title,
        ?string $titleRu,
        ?string $slug,
        ?string $keywords,
        ?string $description,
        bool $active = null,
        ?string $metaTitle = null,
        ?string $metaDescription = null
    ) {
        $this->title = $title;
        $this->titleRu = $titleRu;
        $this->slug = $slug;
        $this->keywords = $keywords;
        $this->description = $description;
        $this->active = $active;
        $this->createAt = new DateTimeImmutable();
        $this->updateAt = null;
        $this->counter = 0;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string|null
     */
    public function getReferrerCounter(): ?string
    {
        return $this->referrerCounter;
    }

    /**
     * @return string | null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitleRu(): ?string
    {
        return $this->titleRu;
    }

    /**
     * @return string|null
     */
    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getCounter(): int
    {
        return $this->counter;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreateAt(): DateTimeImmutable
    {
        return $this->createAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdateAt(): ?DateTimeImmutable
    {
        return $this->updateAt;
    }

    /**
     * @return string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Post
     */
    public function updateCounter(): self
    {
        $this->counter++;

        return $this;
    }

    /**
     * @return Post
     */
    public function updateReferrerCounter(): self
    {
        $this->referrerCounter++;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string | null
     */
    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    /**
     * @return string | null
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string|null $titleRu
     */
    public function setTitleRu(?string $titleRu): void
    {
        $this->titleRu = $titleRu;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }

    /**
     * @param string|null $metaDescription
     */
    public function setMetaDescription(?string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @param string|null $metaTitle
     */
    public function setMetaTitle(?string $metaTitle): void
    {
        $this->metaTitle = $metaTitle;
    }
}
