<?php

namespace App\Controller;

use App\Entity\Album;
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
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     *
     * @Route("/", name="home")
     */
    public function index()
    {
        /** @var AlbumRepository $albumRepository */
        $albumRepository = $this->getDoctrine()->getRepository(Album::class);

        $res    = $albumRepository->findOneBySomeField('Madame Bovary mère');
        $albums = $albumRepository->findThreeForHome();

        return $this->render('home/index.html.twig', [
            'controller_name'   => 'HomeController',
            'res'               => $res,
            'albums'            => $albums,
        ]);
    }
}
