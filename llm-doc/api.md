# icons — API of `Blackcube\Icons\Svg`

## Lifecycle

An icon is rendered in three steps: factory → set selector (gives the name) → optional setters → `render()`. Every method except `render()` and `__toString()` returns a **clone**: the original object is never modified.

```php
use Blackcube\Icons\Svg;

echo Svg::heroicon()->outline('arrow-up-tray')->addClass('size-6', 'text-primary-600');
```

## Factories (static)

| Method | Family | Folder read |
|---|---|---|
| `Svg::heroicon(): static` | Heroicons | `src/resources/heroicons/` |
| `Svg::icon(): static` | custom icons | `src/resources/customicons/` |

## Set selectors (set the name)

| Method | Factory to use | File read | Default viewBox |
|---|---|---|---|
| `outline(string $name)` | `heroicon()` | `heroicons/normal/outline.php` | `0 0 24 24` |
| `solid(string $name)` | `heroicon()` | `heroicons/normal/solid.php` | `0 0 24 24` |
| `mini(string $name)` | `heroicon()` | `heroicons/mini/solid.php` | `0 0 20 20` |
| `micro(string $name)` | `heroicon()` | `heroicons/micro/solid.php` | `0 0 16 16` |
| `ui(string $name)` | `icon()` | `customicons/ui/solid.php` | `0 0 24 24`, replaced by the icon's own viewBox when it declares one |
| `logo(string $name)` | `icon()` | `customicons/logo/solid.php` | `0 0 200 200`, same rule |

Measured rules:
- `outline()`, `solid()`, `mini()`, `micro()` do not change the family. `Svg::icon()->solid('eye')` throws `Icons file not found: solid/normal`.
- `ui()` and `logo()` force the custom family. `Svg::heroicon()->ui('checkbox')` works.
- Always write `heroicon()` with outline/solid/mini/micro, and `icon()` with ui/logo.

## Attribute setters (on a clone)

| Method | Effect |
|---|---|
| `id(string $id)` | sets `id` |
| `addClass(string ...$classes)` | appends to the existing `class`, space-separated; accumulates across calls (`addClass('a')->addClass('b', 'c')` → `class="a b c"`) |
| `attribute(string $name, mixed $value)` | sets or replaces one attribute |
| `attributes(array $attributes)` | merges an array (`array_merge`): an existing key is replaced |

## Rendering

- `render(): string` produces `<svg …>content</svg>`. `__toString()` calls `render()`, so `echo` is enough.
- The content (`<path>` and other elements) is not encoded; its elements are joined with a newline.
- **Attribute merge order:** set base attributes → the icon's own `viewBox` if it has one → caller attributes, which win. The caller can therefore replace `viewBox`, `fill`, `stroke`, `aria-hidden` (measured: `attributes(['fill' => 'red'])` replaces `fill="none"`).
- **Base attributes per set.** All sets get `xmlns="http://www.w3.org/2000/svg"`, `aria-hidden="true"`, `data-slot="icon"`, plus:

| Set | Own attributes |
|---|---|
| outline | `fill="none"`, `stroke="currentColor"`, `stroke-width="1.5"`, `viewBox="0 0 24 24"` |
| solid | `fill="currentColor"`, `viewBox="0 0 24 24"` |
| mini | `fill="currentColor"`, `viewBox="0 0 20 20"` |
| micro | `fill="currentColor"`, `viewBox="0 0 16 16"` |
| ui | `fill="none"`, `viewBox="0 0 24 24"` |
| logo | `fill="none"`, `viewBox="0 0 200 200"` |

- **No `class` attribute by default.**
- Each set file is loaded once per process (static cache `$loadedIcons`).

## Exceptions

All are `InvalidArgumentException`, thrown at `render()`:

| Cause | Message |
|---|---|
| no selector called | `SVG name is required. Use outline(), solid(), mini(), micro(), ui() or logo() first.` |
| unknown name in the set | `SVG "<name>" not found in <type>/<size>` |
| wrong factory for the selector, e.g. `icon()->solid()` | `Icons file not found: solid/normal` |
