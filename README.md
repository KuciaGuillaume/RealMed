
# RealMed

Bienvenue dans RealMed ! Ce projet est divisé en deux parties : le frontend (dossier `front`) et le backend (dossier `back`). Ce guide vous explique comment configurer et lancer les deux parties du projet.

## Prérequis

- Node.js (pour le frontend)
- Docker et Docker Compose (pour le backend)

---

## Frontend

### Installation

1. Naviguez dans le dossier `front` :
    ```bash
    cd front
    ```
2. Installez les dépendances :
    ```bash
    npm install
    ```
3. Lancez l'application en mode développement :
    ```bash
    npm run dev
    ```
L'application frontend sera accessible à l'adresse locale affichée dans la console (généralement `http://localhost:5173/`).

### Points importants
- **npm install** : Installe toutes les dépendances requises pour le projet.
- **npm run dev** : Démarre le serveur de développement pour tester l'interface utilisateur.

---

## Backend

Le backend est contenu dans le dossier `back` et utilise Docker pour la gestion de l'environnement.

### Lancer le backend

1. Depuis le dossier racine du projet (ou dans le dossier `back`), exécutez la commande suivante pour démarrer les services :
    ```bash
    docker-compose up
    ```

2. Laissez le conteneur Docker tourner et, dans un autre terminal, exécutez ces commandes pour configurer l'application :

    1. Installez les dépendances PHP avec Composer :
        ```bash
        docker-compose exec app composer install
        ```

    2. Créez une migration pour la base de données :
        ```bash
        docker-compose exec app php bin/console make:migration
        ```

    3. Appliquez les migrations dans la base de données :
        ```bash
        docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction
        ```

    4. Chargez les fixtures (données de test) dans la base de données :
        ```bash
        docker-compose exec app php bin/console doctrine:fixtures:load --no-interaction
        ```

### Points importants
- **docker-compose up** : Démarre les conteneurs Docker pour l'application.
- **composer install** : Installe les dépendances PHP.
- **make:migration** et **migrate** : Génère et applique les migrations pour la base de données.
- **doctrine:fixtures:load** : Charge des données de test pour simuler un environnement réel.

---

## Résumé des commandes

### Frontend :
```bash
cd front
npm install
npm run dev
```

### Backend :
```bash
docker-compose up
docker-compose exec app composer install
docker-compose exec app php bin/console make:migration
docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction
docker-compose exec app php bin/console doctrine:fixtures:load --no-interaction
```
