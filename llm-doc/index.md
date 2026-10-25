# blackcube/icons — LLM index

**Role:** SVG icon sets (Heroicons + Blackcube's own icons) and the `Svg` widget that renders them.

## Package card

| | |
|---|---|
| Namespace | `Blackcube\Icons` |
| Single class | `Svg` (`src/Svg.php`) |
| Requires | PHP ^8.2, `yiisoft/html` ^4.2. No Blackcube dependency. |
| Licenses | code BSD-3-Clause; Heroicons sets MIT (Tailwind Labs) |

## Rules

- Never write raw SVG in a view: every icon goes through `Svg`.
- The widget sets no class: size and colour come from the caller's Tailwind classes.

## Parts

| File | Content | Read when |
|---|---|---|
| `api.md` | The 2 factories (`heroicon()`, `icon()`), the 6 set selectors, the 4 attribute setters, `render()` / `__toString()`. Immutable object (every call clones), `<svg>` attributes produced per set, the 3 reachable exceptions. | before rendering an icon |
| `catalog.md` | The 6 sets: file, icon count (324, 324, 324, 316, 3, 4), viewBox, calling method. Kebab-case names. List of the custom icons. How to check that a name exists. | before choosing an icon name |
| `extension.md` | Add a custom ui/logo icon (format `'name' => ['viewBox' => ..., '<path .../>']`, viewBox optional). Update Heroicons with `bin/update-heroicons`; never hand-edit the 4 generated files. Add a new set (the 5 places to change in `Svg.php`). Extend by inheritance: `Svg` is not final, factories use `new static()`, members are `protected`; application icons via an override of `loadIconData()`. | before adding an icon or a set |
