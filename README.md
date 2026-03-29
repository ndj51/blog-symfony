Markdown
# 🚀 Projet Blog Symfony (MacBook pro)

Ce fichier regroupe toutes les commandes et configurations nécessaires pour faire tourner le projet sur cet environnement Homebrew.

---

## 🛠️ Démarrage des Services

### 1. Services Système (Base de données & Apache)
*À lancer pour activer MySQL et le serveur web local.*
```bash
brew services start mysql
brew services start httpd
2. Serveur Symfony

À lancer à la racine du projet pour accéder au site.

Bash
symfony serve -d
3. Interface phpMyAdmin

Lancer le serveur PHP spécifique pour la gestion BDD (Port 8080).

Bash
cd /opt/homebrew/share/phpmyadmin && php -S localhost:8080
🌐 Liens de Développement
Service	URL	Note
🌍 Site Web	https://127.0.0.1:8000	Application Symfony
🔑 Administration	https://127.0.0.1:8000/admin	Dashboard EasyAdmin
🗄️ Base de données	http://localhost:8080	phpMyAdmin
🛢️ Configuration de la Base
Nom : maker-Land

Utilisateur : root

Mot de passe : (aucun)

Hôte : 127.0.0.1

Note : Sur Mac, le fichier .env.local surcharge le .env pour supprimer le mot de passe "password" utilisé sur Linux.

🏗️ Maintenance & Evolution
Gestion des migrations

Bash
# Créer un fichier de migration après avoir modifié une Entité
php bin/console make:migration

# Appliquer les changements à la base de données
php bin/console doctrine:migrations:migrate
Nettoyage du cache

Bash
php bin/console cache:clear
📝 Roadmap Prochaine Session
Validation BDD : Vérifier la structure de la table article via phpMyAdmin.

Slug Automatique : Implémenter le AsciiSlugger dans l'entité Article.php.

DataFixtures : Créer un script pour générer des articles de test automatiquement.

🛑 Arrêt des Services
Bash
symfony server:stop
brew services stop mysql
brew services stop httpd

Pour mettre le projet en sécurité : 
    git status
    git add .
    git commit -m "détail des nouveautées"
    git push
