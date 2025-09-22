# Documentation UML - Plugin Custom Price Widget

Ce dossier contient les diagrammes UML simplifiés du plugin WordPress **Custom Price Widget** pour le système de chiffrage d'ombrières.

## 📊 Diagrammes disponibles

### 1. Diagramme de Séquence Simplifié (`sequence-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **Objectif** : Flux simplifié en 4 phases principales
- **Phases** :
  1. **Affichage** : Accès page → Formulaire HTML
  2. **Configuration** : Saisie données produit
  3. **Traitement** : Soumission → Calcul prix
  4. **Emails** : Envoi devis client et notification commercial

### 2. Diagramme de Classes Simplifié (`class-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **Objectif** : Architecture modulaire simplifiée
- **Composants principaux** :
  - **Plugin Principal** : Gestion shortcodes et traitement
  - **Calculateur Prix** : Calcul automatique et matières
  - **Système Email** : Envoi devis et notifications
  - **Templates** : Formulaires et emails HTML
  - **WooCommerce** : Intégration panier et produits

### 3. Diagramme d'Objets (`object-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **Objectif** : Instance d'exécution concrète
- **Exemple concret** :
  - Configuration : localhost:3307, debug activé
  - Produit : Pergola Aluminium 4.5x3m, 2850€
  - Client : Jean Dupont, email envoyé
  - Session : Traitement terminé avec succès

### 4. Diagramme d'Activité (`activity-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **Objectif** : Processus métier détaillé
- **Flux complet** :
  - Validation données avec boucle d'erreur
  - Calcul prix automatique
  - Envoi emails parallèle (fork/join)
  - Choix ajout panier ou affichage résultats

### 5. Diagramme de Composants (`component-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **Objectif** : Architecture technique par couches
- **Couches** :
  - **Présentation** : Interface utilisateur et templates
  - **Métier** : Configuration, validation, intégration
  - **Interfaces** : Contrats techniques (IFormHandler, ICalculator, etc.)

### 6. Diagramme de Cas d'Utilisation (`use-case-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **Acteurs** : Visiteur, Client, Commercial, Administrateur
- **Cas d'usage** : Configuration produits, calcul prix, envoi emails, intégration WooCommerce

### 7. Diagramme de Navigation (`navigation-diagram.drawio`)
- **Format** : Draw.io (éditable)
- **États** : Pages WordPress → Formulaires → Résultats → Panier/Emails

## 🏗️ Architecture Simplifiée

### Flux Principal
```
Visiteur → Plugin → Calcul → Email → WooCommerce
```

### Composants Essentiels
- **Plugin Principal** : Point d'entrée et orchestration
- **Calculateur** : Logique métier de pricing
- **Email** : Communication client/commercial
- **Templates** : Rendu HTML responsive
- **WooCommerce** : Intégration e-commerce

### Relations
- **Plugin** utilise tous les autres composants
- **WordPress** est étendu par le plugin
- **Flux de données** : Formulaire → Prix → Email → Produit

## 🔧 Utilisation des Diagrammes

### Édition avec Draw.io
1. Ouvrir [app.diagrams.net](https://app.diagrams.net)
2. Charger le fichier `.drawio` souhaité
3. Modifier selon les besoins
4. Exporter en PNG/PDF pour documentation

### Formats disponibles
- **Draw.io** : Éditable, collaboratif
- **Couleurs** : Code couleur par type de composant
- **Légendes** : Explications des relations et flux

## 📋 Avantages de la Simplification

### Avant (Diagrammes complexes)
- Trop de détails techniques
- Difficile à comprendre pour les non-développeurs
- Maintenance complexe

### Après (Diagrammes simplifiés)
- **Vue d'ensemble claire** : Focus sur l'essentiel
- **Accessibilité** : Compréhensible par tous les intervenants
- **Maintenance facile** : Format Draw.io standard
- **Évolutivité** : Ajout facile de nouveaux éléments

## 🎯 Cas d'Usage des Diagrammes

### Pour les Développeurs
- **Séquence** : Comprendre le flux d'exécution
- **Classes** : Architecture et relations
- **Composants** : Structure technique

### Pour les Chefs de Projet
- **Activité** : Processus métier
- **Cas d'usage** : Fonctionnalités utilisateur
- **Navigation** : Parcours utilisateur

### Pour les Clients
- **Objets** : Exemple concret d'utilisation
- **Activité** : Processus de chiffrage
- **Navigation** : Expérience utilisateur

---

**Format** : Draw.io (éditable)  
**Version** : 2.0 - Simplifiée  
**Dernière mise à jour** : 27 août 2025  
**Compatibilité** : Tous navigateurs modernes
