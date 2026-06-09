# Plateforme de gestion d’équipe (joueurs - entraîneur)

## Contexte

Ce projet a pour objectif de permettre aux joueurs et à l’entraîneur d’un club de football de suivre leurs performances, leur présence aux entraînements ainsi que le suivi des matchs et des convocations.

L’application vise à faciliter la gestion sportive du club et à améliorer la communication entre les différents membres de l’équipe.

---

## Public cible

L’application s’adresse principalement aux clubs de football souhaitant améliorer la communication entre les joueurs et les entraîneurs.

Elle vise à simplifier :

* La gestion des entraînements
* La gestion des convocations
* La gestion des joueurs
* Le suivi des blessures
* Le suivi des performances

Grâce à des fonctionnalités adaptées à chaque rôle.

---

## Site public

* Page d’accueil (section de présentation)
* Présentation des fonctionnalités pour les joueurs et les entraîneurs
* Page d’inscription
* Page de connexion
* Page de contact
* Formulaire de création d’équipe
* Formulaire pour rejoindre une équipe

---

# Fonctionnalités côté joueur

## Rejoindre une équipe

Pour rejoindre une équipe, le joueur recevra un lien de son entraîneur ou devra encoder le code de l’équipe.

Pour cela, il devra au préalable posséder un compte sur l’application.

## Statistiques personnelles

* Nombre de matchs joués
* Nombre de présences aux entraînements

## Communication interne

* Notifications en temps réel
* Convocations
* Changements d’horaire
* Annulations

## Gestion des événements

* Liste des matchs
* Liste des entraînements
* Calendrier des événements
* Indication de disponibilité

À chaque création d’un match ou d’un entraînement, le joueur recevra une notification sur le site ainsi qu’un e-mail.

## Calendrier

Le calendrier permettra de :

* Consulter les entraînements
* Consulter les matchs
* Différencier les événements grâce à plusieurs couleurs

## Historique des présences

Le joueur pourra consulter :

* Ses présences aux entraînements
* Ses présences aux matchs


Le joueur sera informé lorsqu’un :

* Match est créé
* Match est annulé
* Entraînement est créé
* Entraînement est annulé
* Il est convoqué
* Il n’est pas convoqué


# Fonctionnalités côté entraîneur

## Gestion de l’équipe

L’entraîneur crée son équipe puis invite ses joueurs via :

* Un lien d’invitation
* Un code d’équipe

## Tableau de bord

Le tableau de bord affichera :

* Les statistiques de l’équipe
* Les joueurs blessés
* Les joueurs absents
* Les détails associés à chaque statistique

L’entraîneur pourra également modifier le statut d’un joueur.

## Gestion des matchs et entraînements

L’entraîneur pourra :

* Créer des matchs
* Créer des entraînements
* Consulter les disponibilités
* Voir les réponses des joueurs
* Modifier ou supprimer un événement

## Communication

L’entraîneur pourra publier des annonces afin d’informer ses joueurs :

* D’un retard
* D’une annulation
* D’une information importante

## Gestion des convocations

L’entraîneur pourra :

* Sélectionner les joueurs convoqués
* Informer les joueurs de leur statut

## Composition d’équipe

L’entraîneur pourra :

* Choisir une formation
* Associer un joueur à chaque poste
* Préparer son équipe

La composition pourra être exportée au format PDF.

## Actualités

L’entraîneur pourra publier des actualités concernant son équipe.

## Gestion des blessures

## Gestion des joueurs

L’entraîneur pourra :

* Consulter la liste des joueurs
* Ajouter un joueur
* Supprimer un joueur
* Consulter les statistiques détaillées de chaque joueur

## Calendrier

Le calendrier regroupera :

* Tous les matchs
* Tous les entraînements


# Julien – Entraîneur

## Informations générales

* **Âge :** 30 ans
* **Profession :** Employé
* **Rôle :** Entraîneur d'une équipe de football amateur
* **Niveau informatique :** Moyen

### Objectifs

* Gérer facilement son équipe.
* Organiser les entraînements et les matchs.
* Communiquer rapidement avec ses joueurs.
* Gagner du temps dans la gestion administrative.

### Frustrations

* Utiliser plusieurs outils différents (WhatsApp, papier, Excel...).
* Devoir contacter chaque joueur individuellement.
* Ne pas savoir rapidement qui est disponible ou absent.
* Perdre du temps dans l'organisation des convocations.

### Besoins

* Créer des événements rapidement.
* Envoyer des convocations.
* Préparer sa composition d'équipe.
* Consulter les statistiques de ses joueurs.
* Centraliser toutes les informations au même endroit.

---

# Scénarios d'utilisation

## Scénario 1 – Création de sa première équipe

Julien, entraîneur d'une équipe de football, souhaite améliorer la communication avec ses joueurs ainsi que gérer son effectif, ses entraînements et ses matchs, car cela lui prend énormément de temps lorsqu'il doit tout gérer à la main sur papier. De plus, la communication avec ses joueurs n'est pas toujours efficace.

Il découvre que l'application propose de nombreuses fonctionnalités susceptibles de l'intéresser. En parcourant la navigation, il remarque qu'il est possible de créer sa première équipe. Il complète alors le formulaire de création avec les informations demandées.

Une fois son équipe créée, il accède à son tableau de bord où il peut gérer l'ensemble de ses joueurs, ses entraînements et ses matchs.

## Scénario 2 – Ajouter ses joueurs à son équipe

Après avoir créé son équipe, Julien souhaite y ajouter ses joueurs.

Depuis la page de son équipe, il accède à une fonctionnalité lui permettant d'inviter ses joueurs. Il peut soit leur envoyer un lien d'invitation, soit partager un code qu'ils pourront utiliser pour rejoindre l'équipe.

## Scénario 3 – Gestion des joueurs

Depuis son tableau de bord, Julien peut consulter le nombre de joueurs présents dans son équipe. En cliquant sur cette statistique, il accède à la liste complète de ses joueurs, classés par poste.

Pour chaque joueur, il retrouve une photo, son numéro de maillot ainsi que son nom et son prénom. Il peut également ajouter un nouveau joueur ou supprimer un joueur existant.

Une barre de recherche lui permet de retrouver rapidement un joueur à partir de son nom ou de son prénom.

Lorsqu'il sélectionne un joueur, Julien accède à sa fiche détaillée contenant différentes statistiques telles que le nombre de matchs joués, le nombre d'entraînements suivis ou manqués, ainsi que son statut actuel (disponible ou blessé).

## Scénario 4 – Gestion des matchs et des entraînements

Julien souhaite organiser la semaine de son équipe.

Depuis son tableau de bord, il peut créer deux types d'événements : un match ou un entraînement. Il choisit une date dans le calendrier puis complète les informations de l'événement telles que le lieu, les horaires et une éventuelle note destinée aux joueurs.

Une fois créé, l'événement apparaît dans sa liste d'événements. Il peut ensuite le modifier ou l'annuler si nécessaire.

Lorsqu'un nouvel événement est créé, tous les joueurs reçoivent une notification. Ils peuvent consulter les informations de l'événement et indiquer leur présence ou leur absence en ajoutant éventuellement un commentaire explicatif.

Julien peut suivre en temps réel le nombre de joueurs ayant répondu à l'événement.

## Scénario 5 – Gestion des convocations aux matchs

Le match de samedi approche et Julien souhaite préparer ses convocations.

Depuis la page du match concerné, il accède à la liste des joueurs de son équipe et sélectionne ceux qu'il souhaite convoquer.

Une fois sa sélection terminée, il valide la convocation. Chaque joueur concerné reçoit alors une notification l'informant de sa convocation.

Julien dispose ensuite d'une vue récapitulative affichant les réponses des joueurs ainsi que leur statut de présence. Il est également averti lorsqu'un joueur répond à sa convocation.

## Scénario 6 – Préparation du match

Après avoir reçu les réponses de ses joueurs, Julien passe à la préparation de sa composition d'équipe.

Depuis la page du match, il clique sur le bouton permettant de créer sa composition. Il accède alors à une interface où il peut choisir la formation qu'il souhaite utiliser pour la rencontre.

À droite de l'écran, il retrouve tous les joueurs convoqués. Il peut les rechercher, les filtrer par poste ou parcourir la liste complète.

Il construit ensuite son équipe en assignant un joueur à chaque poste de la formation sélectionnée.

Une fois sa composition terminée, Julien peut l'imprimer ou l'exporter afin de l'utiliser le jour du match.

# Lucas – Joueur

## Informations générales

* **Âge :** 17 ans
* **Situation :** Étudiant
* **Rôle :** Joueur de football
* **Niveau informatique :** Bon

### Objectifs

* Consulter facilement les informations de son équipe.
* Répondre rapidement aux convocations.
* Suivre ses statistiques personnelles.
* Connaître les horaires des entraînements et des matchs.

### Frustrations

* Oublier les horaires des événements.
* Recevoir les informations à différents endroits.
* Ne pas savoir rapidement s'il est convoqué ou non.
* Ne pas avoir de suivi de ses performances.

### Besoins

* Recevoir des notifications importantes.
* Consulter son calendrier.
* Répondre aux convocations.
* Encoder ses statistiques personnelles.
* Accéder à l'historique de ses performances.

---

# Scénarios d'utilisation

## Scénario 1 – Rejoindre son équipe

Lucas a rejoint l'équipe il y a une semaine. En discutant avec ses coéquipiers, il apprend que la communication de l'équipe passe par une application dédiée.

Il se rend alors sur le site et utilise la fonctionnalité permettant de rejoindre une équipe. Il encode le code transmis par son entraîneur dans le groupe WhatsApp de l'équipe.

Une fois le code validé, Lucas rejoint automatiquement son équipe et accède à son tableau de bord.

## Scénario 2 – Consulter les matchs et les entraînements

Lucas souhaite connaître les prochains entraînements ainsi que le match prévu cette semaine.

Ayant reçu plusieurs notifications concernant de nouveaux événements, il ouvre le calendrier de l'application. Celui-ci lui permet de visualiser facilement les entraînements et les matchs à venir.

En cliquant sur l'entraînement du mardi, il peut consulter toutes les informations utiles comme l'heure de début et le lieu de rendez-vous.

## Scénario 3 – Suivre ses statistiques

Lucas souhaite suivre ses performances tout au long de la saison.

Il accède à la page dédiée aux statistiques où il retrouve un résumé de ses données personnelles telles que ses présences aux entraînements, ses présences aux matchs ainsi que ses absences.

Sous ce résumé, il retrouve la liste des matchs pour lesquels il a été convoqué. En sélectionnant un match, il peut encoder ses statistiques personnelles afin de suivre sa progression au fil de la saison.

## Scénario 4 – Répondre à une convocation

Lucas reçoit une notification sur l'application. En l'ouvrant, il découvre qu'il s'agit d'une convocation pour le match du samedi.

Depuis la page de la convocation, il peut indiquer s'il sera présent ou absent et ajouter un commentaire destiné à son entraîneur si nécessaire.

Une fois sa réponse envoyée, il retrouve directement le match dans son tableau de bord avec toutes les informations importantes telles que l'heure et le lieu de la rencontre.

# Procédure d'installation

1. Cloner le projet :

```bash
git clone <url-du-projet>
```

2. Se placer dans le dossier du projet :

```bash
cd nom-du-projet
```

3. Installer les dépendances PHP :

```bash
composer install
```

4. Installer les dépendances JavaScript :

```bash
npm install
```

5. Copier le fichier d'environnement :

```bash
cp .env.example .env
```

6. Générer la clé de l'application :

```bash
php artisan key:generate
```

7. Créer la base de données et injecter les données de test :

```bash
php artisan migrate:fresh --seed
```

8. Lancer le projet :

```bash
composer run dev
```

L'application est maintenant accessible depuis le navigateur à l'adresse indiquée dans le terminal.

# Stack technique

## Backend

* **PHP 8.2**
* **Laravel 12**
* **Eloquent ORM**
* **Laravel Notifications**
* **Laravel Queues**

## Frontend

* **Blade**
* **Livewire 4**
* **Alpine.js**
* **Tailwind CSS**
* **Vite**

## Base de données

Mysql

## Bibliothèques et packages

### Gestion du calendrier

* **act-training/livewire-calendar**

Permet l'affichage et la gestion des événements dans le calendrier de l'application.

### Génération de données de test

* **FakerPHP**

Utilisé pour générer des données fictives lors du développement et des tests.

## Tests

### Tests unitaires et fonctionnels

* **Pest PHP**
* **Pest Laravel Plugin**

### Tests navigateur (Browser Testing)

* **Pest Browser Plugin**
* **Laravel Dusk**

Permettent de tester les interactions utilisateur directement dans le navigateur.

## Outils de développement

* **Laravel Debugbar**

## Gestion de version

* **Git**
* **GitHub**

