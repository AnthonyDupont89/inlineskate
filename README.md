# Inline Skate — Gestion de cours de roller

Application web PHP de gestion de séances de cours de roller en ligne droite. Projet personnel réalisé dans un but pédagogique et de portfolio.

## Fonctionnalités

- **Inscription / Connexion** avec hachage des mots de passe (bcrypt)
- **Deux profils utilisateurs** : moniteur et élève
- **Moniteurs** : créer des séances de cours (date, heure, niveau, nombre de places)
- **Élèves** : consulter les séances disponibles, s'inscrire et se désinscrire
- **Sécurité** : protection CSRF, validation serveur, régénération d'ID de session

## Stack technique

| Couche | Technologie |
|--------|-------------|
| Langage | PHP 8.2+ |
| Base de données | MySQL 8+ / MySQLi |
| Dépendances | Composer + vlucas/phpdotenv |
| Serveur local | Laragon (Apache) |
| Front-end | HTML, CSS (vanilla) |

## Architecture

Pattern **MVC** avec Front Controller :

```
inlineskate/
├── app/
│   ├── Controllers/        # Logique métier (Auth, Lesson, Page)
│   ├── Models/             # Accès base de données (User, Lesson, Enrollment, Level)
│   ├── Database.php        # Connexion MySQLi (singleton)
│   └── Router.php          # Routeur HTTP (GET/POST) + validation CSRF
├── database/
│   ├── schema.sql          # Structure de la base de données
│   └── seed.sql            # Données de test
├── public/                 # Seul dossier exposé par Apache
│   ├── index.php           # Front Controller (point d'entrée unique)
│   ├── .htaccess           # Réécriture d'URL vers index.php
│   ├── css/
│   ├── fonts/
│   └── images/
├── views/                  # Templates PHP (layout + pages)
├── bootstrap.php           # Initialisation (autoload, .env, session, CSRF)
├── routes.php              # Déclaration de toutes les routes
└── .env                    # Variables d'environnement (non versionné)
```

## Installation

### Prérequis

- PHP 8.2+
- MySQL 8+
- Composer
- Apache avec `mod_rewrite`

### Étapes

**1. Cloner le dépôt**
```bash
git clone https://github.com/<votre-username>/inlineskate.git
cd inlineskate
```

**2. Installer les dépendances**
```bash
composer install
```

**3. Configurer l'environnement**
```bash
cp .env.example .env
# Éditer .env avec vos identifiants MySQL
```

**4. Créer la base de données**
```sql
-- Dans MySQL / HeidiSQL / phpMyAdmin :
SOURCE database/schema.sql;
SOURCE database/seed.sql;   -- optionnel : données de test
```

**5. Configurer le virtual host Apache**

Pointer le `DocumentRoot` vers le dossier `public/` du projet.

Exemple (Laragon) :
```
<VirtualHost *:80>
    ServerName inlineskate.test
    DocumentRoot "C:/laragon/www/inlineskate/public"
</VirtualHost>
```

**6. Accéder à l'application**

Ouvrir `http://inlineskate.test` dans le navigateur.

### Comptes de test (après `seed.sql`)

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| Moniteur | pierre.dupont@example.com | password123 |
| Élève | marie.martin@example.com | password123 |
| Élève | lucas.bernard@example.com | password123 |

## Sécurité

- **CSRF** : token généré en session, vérifié sur chaque requête POST via `hash_equals()`
- **Mots de passe** : hachés avec `PASSWORD_BCRYPT`
- **SQL** : requêtes préparées MySQLi (aucune concaténation de variables dans le SQL)
- **XSS** : toutes les sorties passent par `htmlspecialchars()`
- **Sessions** : `session_regenerate_id(true)` après chaque connexion
- **Validation** : contrôle serveur systématique (email, longueur, rôle autorisé)

## Auteur

Anthony — [GitHub](https://github.com/<votre-username>)
