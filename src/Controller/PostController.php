<?php
// src/Controller/PostController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PostRepository;
use App\Repository\CategoryRepository;
use App\Entity\Post;
use App\Entity\Category;
use Parsedown;

final class PostController extends AbstractController
{
    #[Route('/blog', name: 'app_post')]
    public function index(PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'categories' => $categoryRepository->findAll(),
        ]);
    }
    #[Route('/blog/category/{id}', name: 'app_post_category')]
    public function category(int $id, PostRepository $postRepository, CategoryRepository $categoryRepository): Response
    {
        // On récupère la catégorie en question
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        return $this->render('post/index.html.twig', [
            // On ne récupère que les articles liés à cette catégorie
            'posts' => $postRepository->findBy(['category' => $category]),            
            'categories' => $categoryRepository->findAll(),
            'currentCategory' => $category, // Utile pour savoir quelle pill activer
        ]);
    }
    #[Route('/blog/article/{id}', name: 'app_post_show')]
    public function show(Post $post, CategoryRepository $categoryRepository): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }
}
