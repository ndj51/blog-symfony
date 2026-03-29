<?php

namespace App\Controller;

use App\Form\UserProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/mon-profil', name: 'app_user_profile')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        // 1. On récupère l'utilisateur connecté
        /** @var \App\Entity\User $user */
        $user = $this->getUser();

        // Sécurité : si l'utilisateur n'est pas connecté, on le renvoie à la page de login
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // 2. On crée le formulaire en le liant à l'entité de l'utilisateur
        $form = $this->createForm(UserProfileType::class, $user);

        // 3. On demande au formulaire de lire la requête
        $form->handleRequest($request);

        // 4. Si le formulaire est soumis et valide, on enregistre
        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de persist() car l'objet $user vient déjà de la BDD
            $em->flush();

            $this->addFlash('success', 'Ton profil "Maker" a été mis à jour !');

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('user/index.html.twig', [
            'profileForm' => $form->createView(),
        ]);
    }
}