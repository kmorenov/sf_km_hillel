<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

use App\Service\MainManager;

/**
 * @Route("/km")
 */
class MainController extends Controller   //AbstractController
{
    /**
     * @Route("/main", name="main")
     * @Route("/", name="main")
     */
    public function index(ArticleRepository $articleRepository)
    {
//        $mm = $this->get(MainManager::class);   *** NOT NEEDED YET
        $articles = $articleRepository->findAll();
        return $this->render('main/index.html.twig', ['articles' => $articles]);
//        return $this->denyAccessUnlessGranted('main/index.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/article/{id}", name="article")
     */
    public function article($id, ArticleRepository $articleRepository)
    {
        $article = $articleRepository->find($id);
        return $this->render('main/article.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function categories(CategoryRepository $categoryRepository)
    {
//        $categories = $this->container->get('doctrine')->getRepository(Category::class);
        $categories = $categoryRepository->findAll();
        return $this->render('main/categories.html.twig', compact('categories'));
    }

    /**
     * @Route("/category/{id}", name="category")
     */
    public function category($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);
        return $this->render('main/category.html.twig', ['category' => $category]);
    }


}
