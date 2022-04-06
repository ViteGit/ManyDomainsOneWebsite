<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\LinkRepository;
use App\Repository\PageRepository;
use App\Repository\SiteRepository;
use App\Repository\VideoRepository;
use App\VO\PageDescriminator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var VideoRepository
     */
    private $videoRepository;

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var LinkRepository
     */
    private $linkRepository;

    /**
     * @var SiteRepository
     */
    private $siteRepository;

    /**
     * @param CategoryRepository $categoryRepository
     * @param VideoRepository $videoRepository
     * @param PageRepository $pageRepository
     * @param LinkRepository $linkRepository
     * @param SiteRepository $siteRepository
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        VideoRepository $videoRepository,
        PageRepository $pageRepository,
        LinkRepository $linkRepository,
        SiteRepository $siteRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->videoRepository = $videoRepository;
        $this->pageRepository = $pageRepository;
        $this->linkRepository = $linkRepository;
        $this->siteRepository = $siteRepository;
    }

    /**
     * @Route("/", name="homepage")
     *
     * @param Request $request
     * @return Response
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function homepage(Request $request)
    {
        $limit = $this->getParameter('numberOfLinesPerPage');
        $site = $this->siteRepository->findOneBy(['domain' => $request->getHost()]);
        $links = $this->linkRepository->findBySiteId($site->getId());
        $page = $this->pageRepository->getByDescriminator(PageDescriminator::HOMEPAGE);
        $categories = $this->categoryRepository->findAll();
        $videos = $this->videoRepository->findAll();

        return $this->render('index.html.twig', [
            'pageNumber' => $request->get('page') ?? 1,
            'pageCount' => ceil($this->videoRepository->getFilteredLinesCount() / $limit),
            'categories' => $categories,
            'page' => $page,
            'links' => $links,
            'site' => $site,
            'videos' => $videos,
        ]);
    }


    /**
     * @Route("/category/{slug}", name="category")
     *
     * @param Request $request
     * @param string $slug
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function category(Request $request, string $slug)
    {
        $limit = $this->getParameter('numberOfLinesPerPage');
        $page = $request->get('page') ?? 1;
        $offset = ($limit * $page) - $limit;

        $site = $this->siteRepository->findOneBy(['domain' => $request->getHost()]);
        $links = $this->linkRepository->findBySiteId($site->getId());

        $page = $this->pageRepository->getByDescriminator(PageDescriminator::CATEGORY);
        $categories = $this->categoryRepository->findAll();
        $category = $this->categoryRepository->findOneBy(['slug' => $slug]);

        $videos = $this->videoRepository->findByFilters($limit,$offset,[$category->getId()]);

        return $this->render('index.html.twig', [
            'pageNumber' => $request->get('page') ?? 1,
            'pageCount' => ceil($this->videoRepository->getFilteredLinesCount([$category->getId()]) / $limit),
            'videos' => $videos,
            'categories' => $categories,
            'category' => $category,
            'page' => $page,
            'links' => $links,
            'site' => $site,
        ]);
    }

    /**
     * @Route("/view/{slug}", name="view")
     *
     * @param Request $request
     * @param string $slug
     *
     * @return Response
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function view(Request $request, string $slug)
    {
        $site = $this->siteRepository->findOneBy(['domain' => $request->getHost()]);
        $video = $this->videoRepository->findOneBy(['slug' => $slug]);
        $page = $this->pageRepository->getByDescriminator(PageDescriminator::VIDEO);
        $categories = $this->categoryRepository->findAll();
        $links = $this->linkRepository->findAll();

        return $this->render('view.html.twig', [
            'page' => $page,
            'categories' => $categories,
            'video' => $video,
            'links' => $links,
            'site' => $site,
        ]);
    }
}
