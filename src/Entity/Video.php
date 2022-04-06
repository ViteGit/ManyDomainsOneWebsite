<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

/**
 * @ORM\Table(name="video")
 * @ORM\Entity(repositoryClass="App\Repository\VideoRepository")
 */
class Video extends Post
{
    /**
     * @var string
     *
     * @ORM\Column(name="poster", type="string")
     */
    private $poster;

    /**
     * @var string
     *
     * @ORM\Column(name="poster_width", type="string", nullable=true)
     */
    private $posterWidth;

    /**
     * @var string
     *
     * @ORM\Column(name="poster_height", type="string", nullable=true)
     */
    private $posterHeight;

    /**
     * @var string
     *
     * @ORM\Column(name="img_0", type="string")
     */
    private $img0;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", nullable=true)
     */
    private $duration;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="video_category",
     *  joinColumns={@ORM\JoinColumn(name="video_id", referencedColumnName="id")},
     *  inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    protected $categories;

    /**
     * @var string | null
     *
     * @ORM\Column(name="width", type="string", nullable=true)
     */
    private $width;

    /**
     * @var string | null
     *
     * @ORM\Column(name="height", type="string", nullable=true)
     */
    private $height;

    /**
     * @var Site
     *
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="videos")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=true)
     */
    private $site;

    /**
     * @param string $title
     * @param string|null $titleRu
     * @param string|null $slug
     * @param string|null $keywords
     * @param string|null $description
     * @param string $poster
     * @param string $img0
     * @param string|null $link
     * @param string $duration
     * @param array $categories
     * @param DateTimeImmutable|null $dataReleased
     * @param bool $active
     * @param string|null $metaTitle
     * @param string|null $metaDescription
     * @param string|null $width
     * @param string|null $height
     * @throws Exception
     */
    public function __construct(
        string $title,
        ?string $titleRu,
        ?string $slug,
        ?string $keywords,
        ?string $description,
        string $poster,
        string $img0,
        ?string $link,
        string $duration,
        array $categories = [],
        ?DateTimeImmutable $dataReleased = null,
        bool $active = false,
        ?string $metaTitle = null,
        ?string $metaDescription = null,
        ?string $width = null,
        ?string $height = null
    ){
        $this->poster = $poster;
        $this->img0 = $img0;
        $this->link = $link;
        $this->duration = $duration;
        $this->categories = new ArrayCollection(array_unique($categories, SORT_REGULAR));

        parent::__construct(
            $title,
            $titleRu,
            $slug,
            $keywords,
            $description,
            $active,
            $metaTitle,
            $metaDescription
        );
    }

    /**
     * @return string
     */
    public function getPosterHeight(): ?string
    {
        return $this->posterHeight ?? '360';
    }

    /**
     * @return string
     */
    public function getPosterWidth(): ?string
    {
        return $this->posterWidth ?? '640';
    }

    /**
     * @param string $posterHeight
     */
    public function setPosterHeight(string $posterHeight): void
    {
        $this->posterHeight = $posterHeight;
    }

    /**
     * @param string $posterWidth
     */
    public function setPosterWidth(string $posterWidth): void
    {
        $this->posterWidth = $posterWidth;
    }

    /**
     * @return string
     */
    public function getWidth(): ?string
    {
        return $this->width ?? '640';
    }

    /**
     * @return string
     */
    public function getHeight(): ?string
    {
        return $this->height ?? '360';
    }

    /**
     * @param string $width
     */
    public function setWidth(string $width): void
    {
        $this->width = $width;
    }

    /**
     * @param string $height
     */
    public function setHeight(string $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string | null
     */
    public function getImg0(): ?string
    {
        return $this->img0;
    }


    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @return string | null
     */
    public function getPoster(): ?string
    {
        return $this->poster;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration ?? 0;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }


    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param ArrayCollection $categories
     *
     * @return Video
     */
    public function setCategories(ArrayCollection $categories): self
    {
        $this->categories = new ArrayCollection(array_unique($categories->toArray(), SORT_REGULAR));

        return $this;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->id;
    }

    /**
     * @param string $text
     *
     * @return string
     */
    private function formatTitle(string $text): string
    {
        return implode(' ', array_map(function($word) {
            if (strlen($word) > 2) {
                return mb_strtoupper(mb_substr($word, 0, 1)) . mb_substr($word, 1);
            } else {
                return $word;
            }
        }, explode(' ', $text)));
    }

    /**
     * @throws Exception
     */
    public function setUpdateAt(): self
    {
        $this->updateAt = new DateTimeImmutable();

        return $this;
    }


    /**
     * @param string $poster
     */
    public function setPoster(string $poster): void
    {
        $this->poster = $poster;
    }

    /**
     * @param string $img0
     */
    public function setImg0(string $img0): void
    {
        $this->img0 = $img0;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'duration' => $this->duration,
            'link' => $this->link,
        ];
    }
}
