<?php

namespace App\Twig;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('getArticleUrlById', [$this, 'getArticleUrlById']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getArticleUrlById', [$this, 'getArticleUrlById']),
        ];
    }

    public function getArticleUrlById($id)
    {
//        dump($this->router);
        return $this->router->generate('article_show', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL);
    }

    public function doSomething($value)
    {
        // ...
    }

}
