<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="article_index", methods="GET")
     */
    public function index(ArticleRepository $articleRepository, Request $request, ParameterBagInterface $parameterBag): Response
    {
        dump('APP_SECRET: ' . getenv('APP_SECRET'));
        return $this->render('article/index.html.twig', ['articles' => $articleRepository->findAll()]);
    }

    /**
     * @Route("/new", name="article_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->imageUpload($this->getParameter('uploads_directory'));
            $article->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_index');
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="article_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/{id}/edit", name="article_edit", methods="GET|POST")
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->imageUpload($this->getParameter('uploads_directory'));

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('article_updated', 'Article: ' . $article->getTitle() . ' was updated.');

            return $this->redirectToRoute('article_edit', ['id' => $article->getId()]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="article_delete", methods="DELETE")
     */
    public function delete(Request $request, Article $article): Response
    {
        if ($this->isCsrfTokenValid('delete' . $article->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('article_index');
    }
    CONST UPLOAD_DIR = '/uploads/';
    public function getImagePath()
    {
        if ($this->getImage()) {
            return UPLOAD_DIR . $this->getImage();
        }
        return UPLOAD_DIR . 'notFound.jpg';
    }
}
