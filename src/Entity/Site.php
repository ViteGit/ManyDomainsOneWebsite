<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

/**
 * @ORM\Table(name="site")
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $domain;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $counter;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Page", mappedBy="site")
     */
    private $pages;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Link", mappedBy="site")
     */
    private $links;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Video", mappedBy="site")
     */
    private $videos;

    /**
     * @var
     *
     * @ORM\OneToMany(targetEntity="Category", mappedBy="site")
     */
    private $categories;

    /**
     * @param mixed $domain
     */
    public function setDomain($domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @param mixed $counter
     */
    public function setCounter($counter): void
    {
        $this->counter = $counter;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos): void
    {
        $this->videos = $videos;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @param mixed $links
     */
    public function setLinks($links): void
    {
        $this->links = $links;
    }

    /**
     * @param mixed $pages
     */
    public function setPages($pages): void
    {
        $this->pages = $pages;
    }

    /**
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getCounter()
    {
        return $this->counter;
    }

    /**
     * @return mixed
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @return mixed
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    public function __toString()
    {
        return $this->title;
    }
}
