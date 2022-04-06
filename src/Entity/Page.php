<?php

namespace App\Entity;

use App\VO\PageDescriminator;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

/**
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="App\Repository\PageRepository")
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="h1", nullable=true)
     */
    private $h1;

    /**
     * @var string | null
     *
     * @ORM\Column(name="h2", nullable=true)
     */
    private $h2;

    /**
     * @var string | null
     *
     * @ORM\Column(name="description", nullable=true, length=1000)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_title", nullable=true)
     */
    private $metaTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="meta_description", type="string", nullable=true)
     */
    private $metaDescription;

    /**
     * @var PageDescriminator
     *
     * @ORM\Embedded(class="App\VO\PageDescriminator", columnPrefix=false)
     */
    private $descriminator;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", nullable=true)
     */
    private $keywords;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="update_at", type="datetime_immutable", nullable=true)
     */
    private $updateAt;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(name="create_at", type="datetime_immutable", nullable=true)
     */
    private $createAt;

    /**
     * @var Site
     *
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="pages")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=true)
     */
    private $site;

    /**
     * @param string $h1
     * @param string $h2
     * @param string $description
     * @param string $metaTitle
     * @param string $metaDescription
     * @param string $keywords
     * @param PageDescriminator $descriminator
     *
     * @throws \Exception
     */
    public function __construct(
        string $h1,
        string $h2,
        string $description,
        string $metaTitle,
        string $metaDescription,
        string $keywords,
        PageDescriminator $descriminator
    ) {
        $this->h1 = $h1;
        $this->h2 = $h2;
        $this->description = $description;
        $this->metaTitle = $metaTitle;
        $this->metaDescription = $metaDescription;
        $this->descriminator = $descriminator;
        $this->keywords = $keywords;
        $this->createAt = new DateTimeImmutable();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getH1(): ?string
    {
        return $this->h1;
    }

    /**
     * @return string|null
     */
    public function getH2(): ?string
    {
        return $this->h2;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getMetaTitle(): ?string
    {
        return $this->metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @return PageDescriminator
     */
    public function getPageDescriminator(): ?PageDescriminator
    {
        return $this->descriminator;
    }

    /**
     * @return string
     */
    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    /**
     * @param string $h1
     */
    public function setH1(string $h1): void
    {
        $this->h1 = $h1;
    }

    /**
     * @param string|null $h2
     */
    public function setH2(?string $h2): void
    {
        $this->h2 = $h2;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle(string $metaTitle): void
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription(string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @param PageDescriminator $descriminator
     */
    public function setPageDescriminator(PageDescriminator $descriminator): void
    {
        $this->descriminator = $descriminator;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }


    /**
     * @return DateTimeImmutable
     */
    public function getUpdateAt(): DateTimeImmutable
    {
        return $this->updateAt;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getUpdateAtAsString(): ?string
    {
        return empty($this->updateAt) ? null : $this->updateAt->format('Y-m-d');
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreateAtAsString(): ?string
    {
        return empty($this->createAt) ? null : $this->createAt->format('Y-m-d');
    }


    /**
     * @return DateTimeImmutable
     */
    public function getCreateAt(): DateTimeImmutable
    {
        return $this->createAt;
    }

    /**
     * @return PageDescriminator
     */
    public function getDescriminator(): PageDescriminator
    {
        return $this->descriminator;
    }

    /**
     * @throws Exception
     */
    public function setUpdateAt(): void
    {
        $this->updateAt = new DateTimeImmutable();
    }

    /**
     * @param DateTimeImmutable $createAt
     * @throws Exception
     */
    public function setCreateAt(): void
    {
        $this->createAt = new DateTimeImmutable();
    }

    /**
     * @param Site $site
     */
    public function setSite(Site $site): void
    {
        $this->site = $site;
    }

    /**
     * @return Site | null
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getPageDescriminator()->getValue();
    }
}
