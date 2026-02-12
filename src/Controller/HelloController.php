<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    #[Route('/', name: 'article_list')]
    public function list(): Response
    {
        return $this->render('hello/index.html.twig');
    }

    #[Route('/new', name: 'article_new')]
    public function new(): Response
    {
        return $this->render('hello/index.html.twig');
    }

    #[Route('/{id}', name: 'article_update')]
    public function update(): Response
    {
        return $this->render('hello/index.html.twig');
    }

    #[Route('/{id}', name: 'article_delete')]
    public function delete(): Response
    {
        return $this->render('hello/index.html.twig');
    }
}