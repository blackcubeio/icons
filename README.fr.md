# Blackcube Icons

Les jeux d'icônes et leur rendu SVG pour Yii 3.

[![License](https://img.shields.io/badge/license-BSD--3--Clause-blue.svg)](LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/blackcube/icons.svg)](https://packagist.org/packages/blackcube/icons)

English version: [README.md](README.md). Ce document est une traduction, le
README anglais fait foi.

Ce paquet redistribue [Heroicons](https://heroicons.com/), l'œuvre de
Tailwind Labs, Inc., publiée sous licence MIT. Blackcube ne les a pas
dessinées et ne revendique rien dessus : voir [Crédits](#crédits).

## Installation

```bash
composer require blackcube/icons
```

## Prérequis

- PHP 8.2
- yiisoft/html

Rien d'autre : le paquet n'a aucune dépendance Blackcube et s'utilise seul.

## Ce que c'est

Deux familles d'icônes et un widget pour les rendre : Heroicons en trois
tailles - normal, mini, micro - et les icônes propres à Blackcube, interface
et logos.

Le widget ne pose aucune classe : c'est l'appelant qui décide de la taille et
de la couleur.

## Usage

```php
use Blackcube\Icons\Svg;

echo Svg::heroicon()->outline('arrow-up-tray')->addClass('size-6');
echo Svg::heroicon()->solid('eye');
echo Svg::heroicon()->mini('exclamation-circle');
echo Svg::heroicon()->micro('check');

echo Svg::icon()->ui('checkbox');
echo Svg::icon()->logo('blackcube');
```

| jeu | appel | viewBox |
|-----|-------|---------|
| Heroicons 24, trait | `Svg::heroicon()->outline($nom)` | `0 0 24 24` |
| Heroicons 24, plein | `Svg::heroicon()->solid($nom)` | `0 0 24 24` |
| Heroicons 20 | `Svg::heroicon()->mini($nom)` | `0 0 20 20` |
| Heroicons 16 | `Svg::heroicon()->micro($nom)` | `0 0 16 16` |
| interface | `Svg::icon()->ui($nom)` | propre à chaque icône |
| logos | `Svg::icon()->logo($nom)` | propre à chaque icône |

Un nom inconnu lève une `InvalidArgumentException` qui le nomme.

## Mettre à jour les Heroicons

```bash
bin/update-heroicons                    dernière version publiée
bin/update-heroicons 2.2.0              une version précise
bin/update-heroicons --source=/chemin   un dossier heroicons déjà présent
```

La commande télécharge l'archive npm officielle, extrait le contenu interne
de chaque SVG et régénère les quatre jeux :

| source Heroicons | fichier généré |
|------------------|----------------|
| `24/outline`     | `normal/outline.php` |
| `24/solid`       | `normal/solid.php` |
| `20/solid`       | `mini/solid.php` |
| `16/solid`       | `micro/solid.php` |

Chaque fichier généré porte en en-tête la version de Heroicons et le
copyright de Tailwind Labs. Les icônes propres à Blackcube -
`customicons/ui`, `customicons/logo` - ne sont jamais touchées : elles ne
viennent pas de Heroicons.

## Tests

```bash
vendor/bin/codecept run
```

## Crédits

Heroicons est l'œuvre de [Tailwind Labs, Inc.](https://tailwindcss.com/),
publiée sous licence MIT. Les jeux de `src/resources/heroicons` sont leur
travail, réempaqueté en tableaux PHP sans aucune modification des tracés. Le
texte complet de la licence est dans
[LICENSE-heroicons.md](LICENSE-heroicons.md).

## Licence

Le code de ce paquet est distribué sous licence BSD-3-Clause.
Voir [LICENSE.md](LICENSE.md).

Copyright (c) 2026 Blackcube - Philippe Gaultier.

Les jeux Heroicons sont sous licence MIT, Copyright (c) Tailwind Labs, Inc.

## Auteur

Philippe Gaultier <philippe@blackcube.io>
