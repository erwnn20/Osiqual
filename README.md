<p align="center">
    <img src="public/img/logo.svg" height="75" alt="Osiqual Logo">
    <h1 align="center">Osiqual</h1>
</p>

<p align="center">
  <a href="https://laravel.com/docs/12.x/" target="_blank">
    <img src="https://img.shields.io/badge/Laravel-12.x-red?logo=laravel" alt="Laravel">
  </a>
  <a href="https://www.php.net/releases/8.2/en.php" target="_blank">
    <img src="https://img.shields.io/badge/PHP-8.2-blue?logo=php" alt="PHP 8.2">
  </a>
  <a href="https://lucide.dev/icons/" target="_blank">
    <img src="https://img.shields.io/badge/Lucide-Icons-f56565?logo=lucide" alt="Lucide Icons">
  </a>
  <a href="https://github.com/rinvex/countries" target="_blank">
    <img src="https://img.shields.io/badge/Rinvex-Countries-0a0a0a?logo=github&logoColor=white" alt="Rinvex Countries">
  </a>
</p>

---

# Table of Contents

- [Installation](#installation)
- [Configuration de la base de données](#configuration-la-base-de-données)
- [Déploiement](#déploiement)
    - [Déploiement en production](#déploiement-en-production)
    - [Déploiement rapide pour développement](#déploiement-rapide-pour-développement)
- [Commandes utiles](#commandes-utiles-récapitulatives)

---

## Installation

### 1. Installer les dépendances

```bash
  composer install
  npm install
```

### 2. Configuration de l'environnement

- Copier le fichier `.env.example` en `.env` :

```bash
  cp .env.example .env
```

- Générer la clé de l’application :

```bash
  php artisan key:generate
```

---

## Configuration la base de données

#### 1. Lancer les migrations :

```bash
  php artisan migrate
```

- Pour lancer les migrations et remplir la base avec les seeders par défaut :

```bash
  php artisan migrate --seed
```

- Pour spécifier un seeder particulier lors du seed :

```bash
  php artisan db:seed --class=YourSeeder
```

> Si la base de données n'existe pas, Laravel vous proposera de la créer. Répondez **oui**.

#### 2. Lancer les migrations :

- Vider et recréer toutes les tables :

```bash
  php artisan migrate:fresh
```

- Seed la base de données (par défaut `DatabaseSeeder`)  :

```bash
  php artisan db:seed
```

- Vider, recréer et seed la base en une seule commande :

```bash
  php artisan migrate:fresh --seed
```

---

## Déploiement

### Déploiement en production

#### 1. Préparation et build du projet

```bash
  composer run prod
```

Cela execute ces commandes :

- `php artisan optimize:clear`
- `php artisan config:cache`
- `php artisan view:cache`
- `npm run build`

#### 2. Lancement du serveur Laravel

```bash
  php artisan serve --host=0.0.0.0 --port=8000
```

Options :

- `--host=0.0.0.0` : rend le serveur accessible depuis l’extérieur (ex. autres machines sur le réseau local)
- `--port=8000` : spécifie le port d’écoute (par défaut 8000).

> ⚠️ Ce mode est adapté pour un déploiement simple et rapide local ou en développement.  
> Pour un déploiement en production réel, il est recommandé d’utiliser un serveur HTTP dédié comme Nginx ou Apache.

### Déploiement rapide pour développement

#### Préparation et build du projet :

```bash
  composer run dev
```

Cela execute ces commandes :

- `php artisan serve` : lance le serveur Laravel (⚠️ *ne pas lancer en même temps que le serveur de prod*).
- `php artisan queue:listen` : écoute les jobs dans la file (utile pour les tests).
- `npm run dev` : compile les assets (JS/CSS) en mode développement avec Vite, avec rechargement automatique à chaque
  sauvegarde.

---

## Commandes utiles récapitulatives

| Commande                           | Description                                           |
|------------------------------------|-------------------------------------------------------|
| `php artisan migrate --seed`       | Migrations + seed par défaut (`DatabaseSeeder`)       |
| `php artisan migrate:fresh --seed` | Supprime, recrée et seed la base                      |
| `composer run dev`                 | Prépare et lance en mode dev (serveur + queue + Vite) |
| `composer run prod`                | Prépare le projet pour production (cache + build)     |
| `php artisan serve`                | lance le serveur Laravel                              |
