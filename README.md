# Morpheus - Plateforme de Cloud Gaming

## Table des matieres

- [Contexte du projet](#contexte-du-projet)
- [Objectifs](#objectifs)
- [Perimetre du projet](#perimetre-du-projet)
- [Architecture generale](#architecture-generale)
- [Fonctionnalites principales](#fonctionnalites-principales)
  - [Authentification et gestion des comptes](#61-authentification-et-gestion-des-comptes)
  - [Abonnements](#62-abonnements)
  - [Catalogue de jeux](#63-catalogue-de-jeux)
  - [File d'attente](#64-file-dattente)
  - [Sessions de jeu](#65-sessions-de-jeu)
  - [Chat systeme](#66-chat-systeme)
  - [Admin](#67-admin)
  - [Securite et acces](#68-securite-et-acces)
  - [Systeme de tournois](#8-systeme-de-tournois)
- [Livrables attendus](#livrables-attendus)
- [Conclusion](#conclusion)

---

## Contexte du projet

Ces dernieres annees, la demande en ressources materielles hautes performances (GPU, CPU, RAM) a explosé, notamment à cause de l'intelligence artificielle. Cela a entraine :

- Une augmentation des prix des cartes graphiques et de la RAM
- Une difficulte d'acces au materiel performant pour les particuliers
- Une obsolescence materielle rapide

Dans le domaine du jeu video, cela empeche beaucoup de joueurs de profiter des jeux recents et exigeants.

Le **cloud gaming** permet de jouer à distance sur des serveurs puissants — l'utilisateur n'a besoin que d'un appareil capable de recevoir un flux video.

Ce projet vise à creer une **plateforme de cloud gaming moderne**, utilisant des APIs et permettant aux utilisateurs de jouer à des jeux via le cloud.

---

## Objectifs

**Objectif principal** : Creer une plateforme de cloud gaming ou les utilisateurs peuvent jouer à des jeux via le cloud avec un systeme d'abonnement, de file d'attente et de sessions de jeu.

---

## Perimetre du projet

### Inclus

- Backend complet (Laravel, APIs REST)
- Integration des services tiers (Steam API, API paiement)
- Gestion des utilisateurs, abonnements, files d'attente, sessions et chat

### Exclus

- Developpement de l'infrastructure cloud (GPU, streaming)

> Le streaming des jeux est assure par **Parsec**.

---

## Architecture generale

La plateforme repose sur un **backend central** qui communique avec le frontend et les services externes via des APIs.

Le backend gere toute la logique : utilisateurs, abonnements, files d'attente, sessions, paiement et chat.

### Technologies utilisees

| Couche | Technologie |
|--------|-------------|
| Frontend | HTML, CSS, JavaScript |
| Backend | PHP, Laravel |
| Base de donnees | PostgreSQL |
| Authentification | Token-based |
| APIs externes | Steam API, API paiement |
| Streaming jeux | Selkies / Moonlight / Sunshine |

---

## Fonctionnalites principales

### 6.1 Authentification et gestion des comptes

- Inscription / connexion (email / mot de passe)
- Connexion via **Steam OAuth**
- CRUD profil utilisateur (lecture, modification)

### 6.2 Abonnements

Modele inspire de **GeForce NOW** :

| Plan | Description |
|------|-------------|
| Free | Acces de base |
| Priority | Priorite dans la file d'attente |
| Ultimate | Acces prioritaire maximal |

- Souscription via API paiement
- Verification d'abonnement cote backend
- Possibilite d'upgrade de plan

### 6.3 Catalogue de jeux

- Liste des jeux disponibles
- Donnees recuperees via **Steam API** (lecture seule — l'admin ne peut pas modifier)
- Affichage des jeux pour l'utilisateur

### 6.4 File d'attente (Queue System)

Systeme de file d'attente pour ne pas surcharger le serveur.

- Acces pour abonnes uniquement
- Priorite selon le plan d'abonnement
- Affichage de la position dans la file
- Possibilite de quitter la file

### 6.5 Sessions de jeu

- Demarrage de session au premier rang de la file
- Streaming via **Moonlight / Sunshine**
- Verification d'abonnement avant demarrage
- Arret automatique si l'utilisateur quitte ou se deconnecte

### 6.6 Chat systeme

#### Chat prive

- Demarrage possible uniquement si au moins un ami est ajoute
- CRUD messages : envoyer, modifier, supprimer
- Le createur peut retirer quelqu'un ou terminer le chat

#### Chat global

- Tous les abonnes peuvent envoyer des messages
- CRUD messages pour l'utilisateur : envoyer, modifier, supprimer, taguer une personne
- L'administrateur peut bannir un utilisateur du chat global

### 6.7 Admin

- Gestion des utilisateurs (CRUD cote admin)
- Gestion des abonnements (CRUD cote admin)
- Supervision des sessions actives :
  - Voir qui joue, quel jeu, duree, plan
  - Possibilite d'arreter une session
- Supervision du chat global

### 6.8 Securite et acces

- Verification d'abonnement avant chaque action
- Verification des droits pour chat / file d'attente / session
- Authentification par token

---

## 8. Systeme de tournois

La plateforme propose un systeme de tournois pour les utilisateurs souhaitant participer à des competitions en ligne sur differents jeux.

### a) Gestion des tournois (Admin)

- Creation de tournois (jeu, date, heure, type de tournoi)
- Modification des informations d'un tournoi
- Suppression d'un tournoi
- Consultation de la liste des tournois

### b) Inscription des utilisateurs

- Inscription à un tournoi
- Desinscription avant le debut du tournoi
- Verification de l'abonnement ou du plan requis pour participer

### c) Gestion des matchs

- Generation automatique des matchs (bracket simple)
- Enregistrement des scores
- Mise à jour des resultats
- Calcul automatique du classement

### d) Classement et resultats

- Affichage du classement des joueurs
- Consultation des resultats des matchs
- Classement visible par tous les utilisateurs

### e) Notifications

- Notification du debut du tournoi
- Notification des resultats
- Notification des matchs à venir

> Le systeme de tournois est integre avec les autres fonctionnalites de la plateforme, notamment les sessions de jeu, le systeme de file d'attente, le chat et les abonnements.

---

## Livrables attendus

- [ ] Code source backend et frontend
- [ ] Diagrammes de conception
- [ ] Planification
- [ ] Maquettes
- [ ] Presentation

---

## Conclusion

Le projet vise à creer une **plateforme de cloud gaming moderne et fonctionnelle**, integrant des APIs externes, du CRUD cote admin et chat, ainsi que la gestion de sessions via Moonlight / Sunshine.

Il permet de demontrer des competences en :

- Developpement web
- Logique metier
- Integration d'APIs
- Gestion de fonctionnalites complexes
