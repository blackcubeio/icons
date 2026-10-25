# Blackcube Icons

Icon sets and their SVG rendering for Yii 3.

[![License](https://img.shields.io/badge/license-BSD--3--Clause-blue.svg)](LICENSE.md)
[![Packagist Version](https://img.shields.io/packagist/v/blackcube/icons.svg)](https://packagist.org/packages/blackcube/icons)

Version française : [README.fr.md](README.fr.md).

This package redistributes [Heroicons](https://heroicons.com/), the work of
Tailwind Labs, Inc., released under the MIT License. Blackcube did not draw
them and claims nothing on them: see [Credits](#credits).

## Installation

```bash
composer require blackcube/icons
```

## Requirements

- PHP 8.2
- yiisoft/html

Nothing else: the package has no Blackcube dependency and works on its own.

## What it is

Two icon families and a widget to render them: Heroicons in three sizes -
normal, mini, micro - and Blackcube's own icons, interface and logos.

The widget sets no class: the caller decides the size and the colour.

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

| set | call | viewBox |
|-----|------|---------|
| Heroicons 24, outline | `Svg::heroicon()->outline($name)` | `0 0 24 24` |
| Heroicons 24, solid | `Svg::heroicon()->solid($name)` | `0 0 24 24` |
| Heroicons 20 | `Svg::heroicon()->mini($name)` | `0 0 20 20` |
| Heroicons 16 | `Svg::heroicon()->micro($name)` | `0 0 16 16` |
| interface | `Svg::icon()->ui($name)` | icon-specific |
| logos | `Svg::icon()->logo($name)` | icon-specific |

An unknown name throws an `InvalidArgumentException` that names it.

## Updating Heroicons

```bash
bin/update-heroicons                    latest published version
bin/update-heroicons 2.2.0              a given version
bin/update-heroicons --source=/path     a heroicons directory already on disk
```

The command downloads the official npm archive, extracts the inner content
of each SVG and regenerates the four sets:

| Heroicons source | generated file |
|------------------|----------------|
| `24/outline`     | `normal/outline.php` |
| `24/solid`       | `normal/solid.php` |
| `20/solid`       | `mini/solid.php` |
| `16/solid`       | `micro/solid.php` |

Each generated file carries the Heroicons version and the Tailwind Labs
copyright in its header. The custom icons - `customicons/ui`,
`customicons/logo` - are never touched: they do not come from Heroicons.

## Tests

```bash
vendor/bin/codecept run
```

## Credits

Heroicons are made by [Tailwind Labs, Inc.](https://tailwindcss.com/) and
released under the MIT License. The sets in `src/resources/heroicons` are
their work, repackaged as PHP arrays without any change to the paths. The
full license text is in [LICENSE-heroicons.md](LICENSE-heroicons.md).

## License

The code of this package is released under the BSD-3-Clause License.
See [LICENSE.md](LICENSE.md).

Copyright (c) 2026 Blackcube - Philippe Gaultier.

The Heroicons sets are MIT, Copyright (c) Tailwind Labs, Inc.

## Author

Philippe Gaultier <philippe@blackcube.io>
