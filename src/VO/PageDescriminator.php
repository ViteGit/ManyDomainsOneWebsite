<?php

namespace App\VO;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable()
 */
class PageDescriminator
{
    public const HOMEPAGE = 'homepage';

    public const ALL_CATEGORIES = 'category_all';

    public const CATEGORIES = 'category_list';

    public const NEWEST_VIDEOS = 'newest_videos';

    public const STUDIOS = 'studio_list';

    public const ACTORS = 'actor_list';

    public const SEARCH = 'search';

    public const CATEGORY = 'category';

    public const VIDEO = 'video';

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, name="page_descriminator")
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }
}
