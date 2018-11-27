<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Repository\CategoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @param AlbumRepository $albumRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     *
     * @Route("/", name="album_index", methods="GET")
     */
    public function index(AlbumRepository $albumRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('album/index.html.twig', [
            //'albums'        => $albumRepository->findAll(),
            'categories'    => $categoryRepository->findAll()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_AUTHOR_ALBUM')")
     *
     * @Route("/new", name="album_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $album->setCreateAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Album $album
     * @return Response
     * @Security("has_role('ROLE_VIEWER_ALBUM')")
     *
     * @Route("/{id}", name="album_show", methods="GET")
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album
        ]);
    }

    /**
     * @param Request $request
     * @param Album $album
     * @return Response
     * @Security("has_role('ROLE_EDITOR_ALBUM')")
     *
     * @Route("/{id}/edit", name="album_edit", methods="GET|POST")
     */
    public function edit(Request $request, Album $album): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_index', ['id' => $album->getId()]);
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Album $album
     * @return Response
     * @Security("has_role('ROLE_MANAGER_ALBUM')")
     *
     * @Route("/{id}/delete", name="album_delete", methods="GET|DELETE")
     */
    public function delete(Request $request, Album $album): Response
    {
        if ($this->isCsrfTokenValid('delete' . $album->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($album);
            $em->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/delete.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @param Request $request
     * @param AlbumRepository $albumRepository
     * @return Response
     *
     * @Route("/albums-filter", name="albums_filter", methods="POST")
     */
    public function albums(Request $request, AlbumRepository $albumRepository): Response
    {
        $category     = $request->get('category');
        //$page       = !empty($request->get('page')) ? $request->get('page') : 1;

        //$count = $pageRepository->countAllCaseStudiesByFilters($region, $type, $project, $page + 1);
        $albums = $albumRepository->findAllAlbumsByFilters($category);

        return $this->render('album/albums.html.twig', [
            'albums'         => $albums,
            //'has_next_page' => $count > 0,
            //'next_page'     => $page + 1
        ]);
    }
}
