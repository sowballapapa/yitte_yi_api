# Yitte Yi API

Bienvenue sur le dépôt de l'API REST de l'application **Yitte Yi**.
Cette API est construite avec le framework [Laravel](https://laravel.com) et sert de backend pour nos applications clientes (ex: Mobile avec Flutter).

## Fonctionnalités principales

- **Authentification & Sécurité** : JWT via Laravel Sanctum, Socialite (Google & Apple) pour web et mobile, Reset de mots de passe.
- **Gestion des Tâches** : CRUD complet pour les tâches avec filtres avancés, pagination et tri.
- **Priorités de Tâches** : Gestion des niveaux de priorités (Basse, Moyenne, Haute, etc.).
- **Préférences Utilisateurs** : Personnalisation de l'expérience (Thème, Langue, Fuseau horaire, Délais de notification).
- **Notifications** : Alertes e-mail (via Brevo SMTP) pour la bienvenue, les rappels d'échéance de tâches et la réinitialisation de mots de passe (avec deep-links mobiles).

## Prérequis

- PHP >= 8.2
- Composer
- Base de données PostgreSQL (ou MySQL)
- Un compte [Brevo](https://www.brevo.com/) (pour l'envoi d'e-mails)

## Installation

1. **Cloner le dépôt**

    ```bash
    git clone <votre-url-git>
    cd yitte_yi_api
    ```

2. **Installer les dépendances**

    ```bash
    composer install
    ```

3. **Configuration de l'environnement**
   Copiez le fichier d'exemple et générez la clé de l'application :

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    _N'oubliez pas de configurer vos accès BDD (`DB\__`), votre SMTP Brevo (`MAIL\__`), ainsi que les clés d'API Socialite dans le fichier `.env`._

4. **Migrations et Seeders**
   Exécutez les migrations et remplissez la base de données avec les données de test (Rôles, Utilisateurs, Priorités, Tâches) :

    ```bash
    php artisan migrate:fresh --seed
    ```

5. **Lancer le serveur local**
    ```bash
    php artisan serve
    ```
    L'API sera accessible sur `http://localhost:8000`.

---

## 📚 Documentation de l'API (Scramble)

La documentation complète et interactive de l'API est générée automatiquement à partir du code source grâce au package **Scramble**.

### Comment y accéder ?

Une fois votre serveur local lancé (`php artisan serve`), rendez-vous simplement sur :

👉 **[http://localhost:8000/docs/api](http://localhost:8000/docs/api)**

### Que contient cette documentation ?

Scramble analyse nos routes, contrôleurs et FormRequests pour générer une spécification **OpenAPI (Swagger)** en temps réel.
Vous y trouverez :

- La liste exhaustive de tous les endpoints (Auth, Tasks, Preferences...).
- Les paramètres attendus (body, query, headers).
- Les règles de validation appliquées.
- Les schémas de réponses (succès et erreurs).
- Un bouton **"Try It"** pour tester les requêtes directement depuis l'interface web (assurez-vous d'abord de récupérer un token Bearer via l'endpoint de Login).

> **Sécurité** : Par défaut, l'accès à `/docs/api` est ouvert en environnement `local`. En environnement de production, seul un utilisateur disposant du rôle **Admin** et connecté pourra y accéder.

### Obtenir le fichier OpenAPI.json brut

Si vous souhaitez importer la documentation dans Postman, Insomnia ou un outil de génération de code client (ex: Swagger Codegen, OpenAPI Generator pour Flutter), le fichier `api.json` brut est disponible ici :

👉 **[http://localhost:8000/docs/api.json](http://localhost:8000/docs/api.json)**

---

## Contribution

Pour toute modification, merci de respecter l'architecture en place :

- Utilisation de **FormRequests** pour la validation.
- Utilisation des **Policies** pour gérer les autorisations de CRUD.
- Les réponses API doivent passer par les méthodes `success()` et `error()` héritées de `ResponseController`.
