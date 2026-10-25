# icons — Extension

## 1. Add a custom icon (in the package)

- Files: `src/resources/customicons/ui/solid.php` (24×24) or `src/resources/customicons/logo/solid.php` (200×200).
- Format: `'name' => ['viewBox' => '0 0 W H', '<path … />', …]`.
- `viewBox` is optional; when present it replaces the set's viewBox (`Svg.php:260-264`).
- The content is not encoded (`encode(false)`, `Svg.php:271`): valid SVG only.
- Colour: `currentColor` in the element, or a class given by the caller. The widget sets no class.

## 2. Update Heroicons

| Command | Source |
|---|---|
| `bin/update-heroicons` | latest version published on npm |
| `bin/update-heroicons 2.2.0` | a given version |
| `bin/update-heroicons --source=/path` | a heroicons directory already on disk |

- Regenerates the 4 files under `src/resources/heroicons/`. Never hand-edit them.
- Never touches `customicons/`.
- After an update: report the counts in `tests/Model/SvgCest.php:142-145` (324/324/324/316 in 2.2.0) and in `catalog.md`.

## 3. Add a new set (in the package)

The 5 places to change in `Svg.php`:

1. a `SIZE_<X>` constant;
2. a `'<type>/<size>'` entry in `$outerSvgAttributes`;
3. a selector modelled on `ui()`;
4. the size in `$validSizes` of `validateSizeType()` (outline is reserved to normal, `Svg.php:293`);
5. the file `src/resources/<heroicons|customicons>/<size>/<type>.php`.

- The size name must be unique across both families: the cache is keyed by size and type, without the family (`Svg.php:303`).
- Heroicons set: also add an entry to `$sets` in `bin/update-heroicons`.

## 4. Extend by inheritance (application side)

- `Svg` is not final; the factories use `new static()`: `AppSvg::icon()` returns an `AppSvg`.
- `protected` members:

| Kind | Members |
|---|---|
| constants | `RESOURCES_DIR`, `HEROICONS_DIR`, `CUSTOMICONS_DIR` |
| statics | `$outerSvgAttributes`, `$loadedIcons` |
| state | `$name`, `$size`, `$type`, `$isHeroicon`, `$attributes` |
| methods | `validateSizeType()`, `loadIconData()` |

Add application icons to an existing set: override `loadIconData()` and merge with `parent::loadIconData()`.

```php
namespace App\Widgets;

use Blackcube\Icons\Svg;

class AppSvg extends Svg
{
    protected const APP_RESOURCES_DIR = __DIR__ . '/resources';

    protected static array $appIcons = [];

    protected function loadIconData(): array
    {
        $directory = $this->isHeroicon === true ? static::HEROICONS_DIR : static::CUSTOMICONS_DIR;
        $key = $directory . '/' . $this->size . '/' . $this->type;
        if (isset(static::$appIcons[$key]) === false) {
            $appFile = static::APP_RESOURCES_DIR . '/' . $key . '.php';
            static::$appIcons[$key] = file_exists($appFile) === true ? require $appFile : [];
        }

        return array_merge(parent::loadIconData(), static::$appIcons[$key]);
    }
}
```

- Application files follow the package layout and format: `resources/customicons/ui/solid.php`, etc.
- Measured: application icons render (`AppSvg::icon()->ui('app-square')`); package icons are unchanged (`AppSvg::icon()->ui('checkbox')`, `AppSvg::heroicon()->outline('eye')`); nothing leaks to the parent (`Svg::icon()->ui('app-square')` throws `SVG "app-square" not found in solid/ui`).
- `array_merge`: an application icon with the same name as a package icon replaces it.
- New set: section 3.
