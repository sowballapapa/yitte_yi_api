<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskPriority;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $low    = TaskPriority::where('name', 'Low')->first();
        $medium = TaskPriority::where('name', 'Medium')->first();
        $high   = TaskPriority::where('name', 'High')->first();

        // Date de référence : 6 mars 2026
        $now = Carbon::create(2026, 3, 6);

        $tasksByUser = [

            // ── Admin ──────────────────────────────────────────────────────────
            'admin@yitte.yi' => [
                [
                    'title'            => 'Audit de sécurité de la plateforme',
                    'content'          => 'Passer en revue les permissions, les logs d\'accès et les configurations serveur afin d\'identifier les vulnérabilités potentielles avant le déploiement en production.',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '08:00:00',
                    'due_datetime'     => $now->copy()->addDays(3)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Mise à jour des dépendances Composer',
                    'content'          => 'Exécuter `composer update`, vérifier les incompatibilités de version et mettre à jour les packages critiques (Laravel, Sanctum, Spatie).',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '09:30:00',
                    'due_datetime'     => $now->copy()->addDays(1)->setTime(12, 0)->toDateTimeString(),
                    'is_completed'     => true,
                    'end_time'         => '11:45:00',
                    'end_date'         => $now->copy()->toDateString(),
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Configurer les alertes Sentry en production',
                    'content'          => 'Intégrer Sentry pour le suivi des erreurs en temps réel, configurer les alertes Slack pour les erreurs critiques (level >= error).',
                    'start_date'       => $now->copy()->addDays(1)->toDateString(),
                    'start_time'       => '10:00:00',
                    'due_datetime'     => $now->copy()->addDays(4)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Rédiger la politique de confidentialité RGPD',
                    'content'          => 'Mettre à jour le document de politique de confidentialité conforme au RGPD, inclure les sections sur la collecte de données, la rétention et les droits des utilisateurs.',
                    'start_date'       => $now->copy()->addDays(2)->toDateString(),
                    'start_time'       => '08:30:00',
                    'due_datetime'     => $now->copy()->addDays(7)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Optimisation des requêtes N+1 sur l\'API',
                    'content'          => 'Identifier et corriger les requêtes N+1 détectées avec Laravel Debugbar, ajouter les eager loading manquants dans les controllers.',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '14:00:00',
                    'due_datetime'     => $now->copy()->addDays(2)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Planifier la réunion trimestrielle Q1 2026',
                    'content'          => 'Convoquer l\'ensemble des équipes pour le bilan Q1 2026 : résultats, objectifs Q2, annonces RH. Préparer les supports de présentation.',
                    'start_date'       => $now->copy()->addDays(5)->toDateString(),
                    'start_time'       => '09:00:00',
                    'due_datetime'     => $now->copy()->addDays(5)->setTime(11, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Mettre en place la stratégie de sauvegarde automatique',
                    'content'          => 'Configurer des snapshots quotidiens de la base de données PostgreSQL avec rétention 30 jours sur S3, tester la procédure de restauration.',
                    'start_date'       => $now->copy()->addDays(1)->toDateString(),
                    'start_time'       => '15:00:00',
                    'due_datetime'     => $now->copy()->addDays(5)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Revoir l\'onboarding des nouveaux utilisateurs',
                    'content'          => 'Analyser les métriques de drop-off lors du flux d\'inscription et proposer des améliorations UX pour réduire l\'abandon de formulaire.',
                    'start_date'       => $now->copy()->addDays(3)->toDateString(),
                    'start_time'       => '10:30:00',
                    'due_datetime'     => $now->copy()->addDays(10)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Intégrer un système de paiement mobile Money',
                    'content'          => 'Implémenter l\'API Orange Money et Wave pour les transactions locales. Tester les webhooks de confirmation en sandbox avant MEP.',
                    'start_date'       => $now->copy()->addDays(7)->toDateString(),
                    'start_time'       => '09:00:00',
                    'due_datetime'     => $now->copy()->addDays(21)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Documenter les endpoints API avec Swagger',
                    'content'          => 'Rédiger la documentation complète des routes REST avec L5-Swagger, inclure des exemples de requêtes et de réponses pour chaque endpoint.',
                    'start_date'       => $now->copy()->addDays(4)->toDateString(),
                    'start_time'       => '13:00:00',
                    'due_datetime'     => $now->copy()->addDays(11)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $low->id,
                ],
                [
                    'title'            => 'Créer le tableau de bord analytique admin',
                    'content'          => 'Développer un dashboard avec les KPIs clés : utilisateurs actifs, tâches créées par jour, taux de complétion, revenus mensuels.',
                    'start_date'       => $now->copy()->addDays(6)->toDateString(),
                    'start_time'       => '08:00:00',
                    'due_datetime'     => $now->copy()->addDays(14)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Vérifier la conformité des données utilisateurs',
                    'content'          => 'Auditer les données sensibles stockées en base (emails, téléphones) et s\'assurer que le chiffrement est appliqué selon les normes en vigueur.',
                    'start_date'       => $now->copy()->addDays(2)->toDateString(),
                    'start_time'       => '11:00:00',
                    'due_datetime'     => $now->copy()->addDays(6)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Mettre en place un CDN pour les assets statiques',
                    'content'          => 'Configurer Cloudflare CDN pour les images, CSS et JS afin de réduire la latence pour les utilisateurs en Afrique de l\'Ouest.',
                    'start_date'       => $now->copy()->addDays(8)->toDateString(),
                    'start_time'       => '10:00:00',
                    'due_datetime'     => $now->copy()->addDays(12)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Former l\'équipe sur les nouvelles fonctionnalités',
                    'content'          => 'Organiser une session de formation interne (2h) pour présenter les nouvelles fonctionnalités déployées en mars 2026 et répondre aux questions.',
                    'start_date'       => $now->copy()->addDays(9)->toDateString(),
                    'start_time'       => '14:00:00',
                    'due_datetime'     => $now->copy()->addDays(9)->setTime(16, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $low->id,
                ],
                [
                    'title'            => 'Préparer le rapport financier de février 2026',
                    'content'          => 'Consolider les données de facturation de février 2026, générer le rapport PDF et l\'envoyer aux parties prenantes avant le 10 mars.',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '16:00:00',
                    'due_datetime'     => $now->copy()->addDays(4)->setTime(12, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
            ],

            // ── User 1 ────────────────────────────────────────────────────────
            'user1@yitte.yi' => [
                [
                    'title'            => 'Finaliser les maquettes UI du module tâches',
                    'content'          => 'Compléter les wireframes Figma pour les écrans de création, d\'édition et de liste de tâches. Partager avec l\'équipe pour validation avant le sprint du 9 mars.',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '08:30:00',
                    'due_datetime'     => $now->copy()->addDays(2)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Rédiger les tests unitaires pour TaskController',
                    'content'          => 'Écrire les tests PHPUnit couvrant les méthodes store, update, destroy et index du TaskController. Viser une couverture de code > 80 %.',
                    'start_date'       => $now->copy()->addDays(1)->toDateString(),
                    'start_time'       => '09:00:00',
                    'due_datetime'     => $now->copy()->addDays(5)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Implémenter les filtres de recherche sur les tâches',
                    'content'          => 'Ajouter des filtres par priorité, statut (complétée / en cours), date de début et mot-clé sur l\'endpoint GET /api/tasks avec pagination.',
                    'start_date'       => $now->copy()->addDays(2)->toDateString(),
                    'start_time'       => '10:00:00',
                    'due_datetime'     => $now->copy()->addDays(6)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Corriger le bug d\'affichage des notifications push',
                    'content'          => 'Les notifications push ne s\'affichent pas sur iOS 17. Investiguer via les logs Firebase Cloud Messaging et proposer un correctif.',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '11:00:00',
                    'due_datetime'     => $now->copy()->addDays(1)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => true,
                    'end_time'         => '16:30:00',
                    'end_date'         => $now->copy()->toDateString(),
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Synchroniser le calendrier des tâches avec Google Calendar',
                    'content'          => 'Intégrer l\'API Google Calendar pour permettre l\'export automatique des tâches avec date d\'échéance vers le calendrier personnel de l\'utilisateur.',
                    'start_date'       => $now->copy()->addDays(5)->toDateString(),
                    'start_time'       => '14:00:00',
                    'due_datetime'     => $now->copy()->addDays(12)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $low->id,
                ],
                [
                    'title'            => 'Préparer la démo client pour la semaine du 9 mars',
                    'content'          => 'Préparer un scénario de démonstration complet (création de compte, ajout de tâches, suivi du progrès) avec un jeu de données réaliste pour le client.',
                    'start_date'       => $now->copy()->addDays(1)->toDateString(),
                    'start_time'       => '13:00:00',
                    'due_datetime'     => $now->copy()->addDays(3)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Mettre en place la fonctionnalité de rappel par SMS',
                    'content'          => 'Intégrer Twilio pour envoyer des rappels SMS 1 heure avant l\'échéance d\'une tâche. Gérer les opt-out et le suivi des envois.',
                    'start_date'       => $now->copy()->addDays(7)->toDateString(),
                    'start_time'       => '09:30:00',
                    'due_datetime'     => $now->copy()->addDays(15)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Améliorer les performances de l\'app mobile Flutter',
                    'content'          => 'Analyser les frames drops avec Flutter DevTools, optimiser les listes longues avec ListView.builder et mettre en cache les images réseau avec cached_network_image.',
                    'start_date'       => $now->copy()->addDays(3)->toDateString(),
                    'start_time'       => '10:00:00',
                    'due_datetime'     => $now->copy()->addDays(8)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Réviser la charte graphique de l\'application',
                    'content'          => 'Mettre à jour les couleurs primaires, la typographie et les espacements dans le design system pour respecter la nouvelle identité visuelle de mars 2026.',
                    'start_date'       => $now->copy()->addDays(4)->toDateString(),
                    'start_time'       => '08:00:00',
                    'due_datetime'     => $now->copy()->addDays(9)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $low->id,
                ],
                [
                    'title'            => 'Configurer le pipeline CI/CD avec GitHub Actions',
                    'content'          => 'Mettre en place un workflow GitHub Actions : lint → tests → build → déploiement automatique sur Railway (staging) à chaque push sur develop.',
                    'start_date'       => $now->copy()->addDays(2)->toDateString(),
                    'start_time'       => '15:00:00',
                    'due_datetime'     => $now->copy()->addDays(7)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
                [
                    'title'            => 'Migrer le stockage des fichiers vers AWS S3',
                    'content'          => 'Configurer le driver S3 de Laravel pour les uploads (avatars, pièces jointes). Créer les buckets avec les bonnes policies IAM et migrer les anciens fichiers.',
                    'start_date'       => $now->copy()->addDays(6)->toDateString(),
                    'start_time'       => '10:00:00',
                    'due_datetime'     => $now->copy()->addDays(11)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Rédiger la newsletter de mars 2026',
                    'content'          => 'Préparer la newsletter mensuelle avec les nouvelles fonctionnalités, les améliorations et les statistiques d\'utilisation de la plateforme pour diffusion le 15 mars.',
                    'start_date'       => $now->copy()->addDays(5)->toDateString(),
                    'start_time'       => '16:00:00',
                    'due_datetime'     => $now->copy()->addDays(9)->setTime(12, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $low->id,
                ],
                [
                    'title'            => 'Ajouter le mode hors ligne à l\'application Flutter',
                    'content'          => 'Implémenter une stratégie de cache local avec Hive pour permettre la consultation et la création de tâches sans connexion internet, avec sync automatique au retour de la connexion.',
                    'start_date'       => $now->copy()->addDays(10)->toDateString(),
                    'start_time'       => '09:00:00',
                    'due_datetime'     => $now->copy()->addDays(20)->setTime(18, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Analyser les retours utilisateurs de février 2026',
                    'content'          => 'Compiler les avis des stores (App Store, Google Play) et les tickets support de février 2026. Prioriser les bugs critiques et les demandes de fonctionnalités récurrentes.',
                    'start_date'       => $now->copy()->toDateString(),
                    'start_time'       => '17:00:00',
                    'due_datetime'     => $now->copy()->addDays(3)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => true,
                    'end_time'         => '18:30:00',
                    'end_date'         => $now->copy()->addDays(1)->toDateString(),
                    'task_priority_id' => $medium->id,
                ],
                [
                    'title'            => 'Tester la compatibilité Android 15',
                    'content'          => 'Exécuter la suite de tests sur un émulateur Android 15 et un vrai appareil, corriger les régressions liées aux nouvelles APIs de gestion des permissions et des notifications.',
                    'start_date'       => $now->copy()->addDays(3)->toDateString(),
                    'start_time'       => '11:00:00',
                    'due_datetime'     => $now->copy()->addDays(7)->setTime(17, 0)->toDateTimeString(),
                    'is_completed'     => false,
                    'end_time'         => null,
                    'end_date'         => null,
                    'task_priority_id' => $high->id,
                ],
            ],
        ];

        foreach ($tasksByUser as $email => $tasks) {
            $user = User::where('email', $email)->first();

            if (!$user) {
                continue;
            }

            foreach ($tasks as $taskData) {
                Task::updateOrCreate(
                    [
                        'title'   => $taskData['title'],
                        'user_id' => $user->id,
                    ],
                    array_merge($taskData, ['user_id' => $user->id])
                );
            }
        }
    }
}
