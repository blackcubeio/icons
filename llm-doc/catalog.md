# icons — set catalog

## The 6 sets

| Set | Call | File | Icons | viewBox | Source |
|---|---|---|---|---|---|
| outline 24 | `Svg::heroicon()->outline($name)` | `src/resources/heroicons/normal/outline.php` | 324 | `0 0 24 24` | Heroicons 2.2.0 |
| solid 24 | `Svg::heroicon()->solid($name)` | `src/resources/heroicons/normal/solid.php` | 324 | `0 0 24 24` | Heroicons 2.2.0 |
| mini 20 | `Svg::heroicon()->mini($name)` | `src/resources/heroicons/mini/solid.php` | 324 | `0 0 20 20` | Heroicons 2.2.0 |
| micro 16 | `Svg::heroicon()->micro($name)` | `src/resources/heroicons/micro/solid.php` | 316 | `0 0 16 16` | Heroicons 2.2.0 |
| ui | `Svg::icon()->ui($name)` | `src/resources/customicons/ui/solid.php` | 3 | per icon | Tailwind UI |
| logo | `Svg::icon()->logo($name)` | `src/resources/customicons/logo/solid.php` | 4 | `0 0 200 200` | Blackcube |

## Heroicons names

- A name is the official Heroicons SVG file name without `.svg`, kebab-case: `arrow-up-tray`, `chevron-right`, `exclamation-circle`.
- outline, solid and mini contain exactly the same 324 names (measured).
- micro has 8 fewer: `arrow-left-on-rectangle`, `arrow-right-on-rectangle`, `arrow-small-down`, `arrow-small-left`, `arrow-small-right`, `arrow-small-up`, `minus-small`, `plus-small`. Requesting one of them in micro throws `SVG "<name>" not found in solid/micro`.

## Custom icons

| Name | Set | viewBox | Colour: who sets it | Real call |
|---|---|---|---|---|
| `checkbox` | ui | `0 0 14 14` | the `<path>` only carry `stroke-width`: the caller provides the stroke colour through a class; each stroke shows through `group-has-checked` / `group-has-indeterminate` (the parent must carry the `group` class) | `bleet/src/Widgets/Checkbox.php:210` |
| `dot` | ui | `0 0 6 6` | `<circle>` without colour and inherited `fill="none"`: the caller sets a `fill-*` class | `bleet/src/Widgets/Badge.php:130` (`fill-primary-500`…) |
| `navigation-separator` | ui | `0 0 22 80` | `stroke="currentcolor"` on the `<path>`: text colour | `bleet/src/Widgets/Views/breadcrumb.php:84`, with `->attribute('preserveAspectRatio', 'none')` |
| `blackcube` | logo | `0 0 200 200` | `fill="currentColor"`: text colour | `dboard/src/Widgets/Sidebar.php:333` |
| `blackcube-name` | logo | `0 0 200 200` | `fill="currentColor"` | — |
| `blerp` | logo | `0 0 200 200` | `fill="currentColor"` | — |
| `bleet` | logo | `0 0 200 200` | `fill="currentColor"` | — |

## Check that a name exists

Never guess a name: read the key in the set file.

```bash
grep -n "'arrow-up-tray' =>" src/resources/heroicons/normal/outline.php
```

A missing name throws `SVG "<name>" not found in <type>/<size>` at `render()`.
