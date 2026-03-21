<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostLike;
use App\Repository\PostLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LikeController extends AbstractController
{
    #[Route('/like/post/{id}', name: 'app_post_like')]
    public function index(Post $post, EntityManagerInterface $manager, PostLikeRepository $likeRepo): Response
    {
        $user = $this->getUser();

        // 1. Sécurité : il faut être connecté
        if(!$user) {
            return $this->json(['code' => 403,
                                'message' => 'il faut être connecté'],
                                 403);
        }

        // 2. On vérifie si l'utilisateur a déjà liké ce post
        if($post->isLikeByUser($user)) {
            $like = $likeRepo->findOneBy([
                'post' => $post,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->redirectToRoute('app_post_show', ['id' => $post->getId()]);
        }

        // 3. Sinon, on crée le like
        $like = new PostLike();
        $like->setPost($post)
             ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->redirectToRoute('app_post_show', [
            'id' => $post->getId(),
        ]);
    }
}
