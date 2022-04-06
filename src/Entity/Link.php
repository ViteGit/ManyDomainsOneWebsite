<?php

namespace App\Entity;

use App\VO\PageDescriminator;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Exception;

/**
 * @ORM\Table(name="link")
 * @ORM\Entity(repositoryClass="App\Repository\LinkRepository")
 */
class Link
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
     * @ORM\Column(type="string")
     */
    private $title;


    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @var Site
     *
     * @ORM\ManyToOne(targetEntity="Site", inversedBy="links")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=true)
     */
    private $site;

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
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
}
