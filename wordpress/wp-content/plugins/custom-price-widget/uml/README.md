# Diagrammes UML - Plugin Custom Price Widget

Ce dossier contient les diagrammes UML du plugin custom-price-widget pour WordPress au format Draw.io.

## Diagrammes disponibles

### 1. Diagramme de Cas d'Utilisation (`use-case-diagram.drawio`)
- **Acteurs** : Visiteur, Client, Commercial, Administrateur WordPress
- **Cas d'utilisation principaux** :
  - Configuration et chiffrage de produits (Pergola, Rideau, Brise-Vue, Voile)
  - Calcul automatique des prix
  - Envoi d'emails (client + commercial)
  - Intégration WooCommerce
  - Administration du plugin

### 2. Diagramme de Séquence (`sequence-diagram.drawio`)
- **Processus complet** : De l'affichage du formulaire à l'envoi des emails
- **Interactions** : WordPress, Plugin, Templates, WooCommerce, Système Email
- **Flux principal** :
  1. Affichage formulaire via shortcode
  2. Configuration produit par l'utilisateur
  3. Traitement et validation des données
  4. Calcul automatique du prix
  5. Envoi dual des emails (client + commercial)
  6. Ajout optionnel au panier WooCommerce

### 3. Diagramme de Classes (`class-diagram.drawio`)
- **Architecture modulaire** du plugin
- **Classes principales** :
  - `CustomPriceWidget` : Classe principale avec shortcodes
  - `ConfigurationManager` : Gestion configuration et environnement
  - `ProductCalculator` : Calculs de prix et logique métier
  - `EmailManager` : Système d'envoi d'emails
  - `WooCommerceIntegration` : Intégration panier et commandes
  - `TemplateRenderer` : Rendu des templates
  - `DataValidator` : Validation et sécurisation des données

### 4. Diagramme de Navigation (`navigation-diagram.drawio`)
- **Flux utilisateur** à travers les différentes pages
- **États et transitions** :
  - Pages WordPress avec shortcodes
  - Formulaires de chiffrage et test
  - Page de résultats
  - Intégration panier WooCommerce
  - Gestion des erreurs

## Utilisation des diagrammes Draw.io

Ces diagrammes Draw.io peuvent être visualisés et modifiés avec :
- **Draw.io en ligne** : [app.diagrams.net](https://app.diagrams.net) (recommandé)
- **VS Code** : Extension Draw.io Integration
- **Desktop** : Application Draw.io Desktop
- **Confluence/Jira** : Plugin Draw.io intégré

## Architecture du Plugin

Le plugin suit une architecture modulaire avec :
- **Séparation des responsabilités** : Chaque classe a un rôle spécifique
- **Configuration externalisée** : `config.php` et `env.php`
- **Templates réutilisables** : Système de templates pour emails et formulaires
- **Intégration WordPress/WooCommerce** : Hooks et filtres standards
- **Sécurité** : Validation et sanitisation des données (à renforcer)

## Points d'amélioration identifiés

D'après l'analyse de sécurité précédente :
- ✅ Validation et sanitisation des données
- ❌ **À implémenter** : Vérification CSRF avec wp_nonce
- ❌ **À corriger** : Suppression des credentials en commentaires
- ❌ **À désactiver** : Mode debug en production
- ❌ **À améliorer** : Gestion d'erreurs plus robuste
