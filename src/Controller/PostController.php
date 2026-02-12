<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    // Liste de tous les posts
    #[Route('/post', name: 'app_post_list')]
    public function list(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        
        return $this->render('post/list.html.twig', [
            'posts' => $posts,
        ]);
    }

    // Créer un nouveau post
    #[Route('/post/new', name: 'app_post_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Post créé avec succès !');
            
            return $this->redirectToRoute('app_post_list');
        }

        return $this->render('post/new.html.twig', [
            'form' => $form,
        ]);
    }

    // Afficher un post spécifique
    #[Route('/post/{id}', name: 'app_post_show', requirements: ['id' => '\d+'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    // Éditer un post
    #[Route('/post/{id}/edit', name: 'app_post_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Post modifié avec succès !');
            
            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        return $this->render('post/edit.html.twig', [
            'form' => $form,
            'post' => $post,
        ]);
    }
}