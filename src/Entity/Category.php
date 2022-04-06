<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="category")
 * @ORM\Entity
 */
class Category extends Post
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="img", type="string", length=255, nullable=true)
     */
    private $img;

    /**
     * @ORM\ManyToMany(targetEntity="Video", mappedBy="categories")
     */
    private $videos;

    /**
     * @var Site
     *
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="categories")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=true)
     */
    private $site;

    /**
     * @param $title
     * @param $slug
     * @param null $titleRu
     * @param $img
     * @param $keywords
     * @param $description
     * @param $metaDescription
     * @param bool $active
     * @param null $metaTitle
     * @throws \Exception
     */
    public function __construct($title, $slug, $titleRu = null, $img = null, $keywords = null, $description = null, $metaDescription = null, $active = false, $metaTitle = null)
    {
        $this->img = $img;

        parent::__construct($title, $titleRu, $slug, $keywords, $description, $active, $metaTitle, $metaDescription);
    }


    /**
     * @return Site
     */
    public function getSite(): Site
    {
        return $this->site;
    }

    /**
     * @return ArrayCollection
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @return string|null
     */
    public function getImg(): ?string
    {
        return $this->img;
    }

    /**
     * @param string|null $img
     */
    public function setImg(?string $img): void
    {
        $this->img = $img;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    /**
     * @return string | null
     */
    public function __toString()
    {
        return $this->titleRu;
    }
}
