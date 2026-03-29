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
use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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
    public function show(Post $post, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user){
                $this->addFlash('error', 'Vous devez être connecté pour laisser un commentaire');
                return $this->redirectToRoute('app_login');
            }
            $comment->setPost($post);
            $comment->setUser($this->getUser()); // Récupère l'user connecté
            $comment->setCreatedAt(new \DateTimeImmutable());

            $em->persist($comment);
            $em->flush();

            // On redirige pour eviter le double envoi au rafraissement
            $this->addFlash('success', 'Votre commentaire a bien été ajouté !');
            return $this->redirectToRoute('app_post_show',['id' => $post->getId()]);
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'commentForm' => $form->createView(),
        ]);
    }
}
