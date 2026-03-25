<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request, 
        UserPasswordHasherInterface $userPasswordHasher, 
        Security $security, 
        EntityManagerInterface $entityManager
    ): Response
    {
        // 1. On crée l'objet User et le formulaire
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        // 2. Traitement du formulaire (quand on clique sur "S'inscrire" depuis /login)
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var string $plainPassword */
            $plainPassword = $form->get('plainPassword')->getData();

            // On hash le mot de passe
            $user->setPassword($userPasswordHasher->hashPassword($user, $plainPassword));

            // On enregistre en base de données
            $entityManager->persist($user);
            $entityManager->flush();

            // Connexion automatique après inscription
            return $security->login($user, 'form_login', 'main');
        }

        // 3. LA RIGUEUR : Si on n'est pas dans le cas d'une soumission réussie,
        // on refuse l'affichage de la page en lançant une 404.
        // Cela utilisera ton template templates/bundles/TwigBundle/Exception/error404.html.twig
        throw $this->createNotFoundException('La page d\'inscription dédiée n\'existe plus.');
    }
}
