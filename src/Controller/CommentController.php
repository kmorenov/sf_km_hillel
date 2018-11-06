<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    /**
     * @Route("{article}/comment", name="comment")
     */
    public function newComment(Article $article, Request $request, EntityManagerInterface $em): Response
    {
        dump($request);
        $comment = new Comment();
        $comment->setArticle($article)
            ->setAuthor($this->getUser())
            ->setContent($request->get('content'));
        $em->persist($comment);
        $em->flush();
        $this->addFlash('article_update', 'Your comment has been added!');
        return $this->redirectToRoute('article', ['id' => $article->getId()]);
    }
}
