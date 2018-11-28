<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends AbstractController
{
    /**
     * @param AlbumRepository $albumRepository
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/", name="home")
     */
    public function index(AlbumRepository $albumRepository)
    {
        return $this->render('home/index.html.twig', [
            'albums' => $albumRepository->findThreeForHome(),
        ]);
    }
}
