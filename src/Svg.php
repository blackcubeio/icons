<?php

declare(strict_types=1);

/**
 * @copyright 2010-2026 Blackcube - Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace Blackcube\Icons;

use InvalidArgumentException;
use Yiisoft\Html\Html;

/**
 * Svg widget for Heroicons and custom icons
 *
 * Usage:
 *   Svg::heroicon()->outline('chevron-right')->render();
 *   Svg::heroicon()->solid('check')->addClass('w-6', 'h-6')->render();
 *   Svg::heroicon()->mini('arrow-left')->render();
 *   Svg::heroicon()->micro('plus')->render();
 *   Svg::icon()->ui('custom-icon')->render();
 *   Svg::icon()->logo('brand')->render();
 *
 * @copyright 2010-2026 Blackcube - Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class Svg
{
    public const SIZE_NORMAL = 'normal';
    public const SIZE_MINI = 'mini';
    public const SIZE_MICRO = 'micro';
    public const SIZE_UI = 'ui';
    public const SIZE_LOGO = 'logo';

    public const TYPE_OUTLINE = 'outline';
    public const TYPE_SOLID = 'solid';

    protected const RESOURCES_DIR = __DIR__ . '/resources';
    protected const HEROICONS_DIR = 'heroicons';
    protected const CUSTOMICONS_DIR = 'customicons';

    protected static array $outerSvgAttributes = [
        'outline/normal' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'fill' => 'none',
            'viewBox' => '0 0 24 24',
            'stroke-width' => '1.5',
            'stroke' => 'currentColor',
            'aria-hidden' => 'true',
            'data-slot' => 'icon',
        ],
        'solid/normal' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 24 24',
            'fill' => 'currentColor',
            'aria-hidden' => 'true',
            'data-slot' => 'icon',
        ],
        'solid/mini' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 20 20',
            'fill' => 'currentColor',
            'aria-hidden' => 'true',
            'data-slot' => 'icon',
        ],
        'solid/micro' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 16 16',
            'fill' => 'currentColor',
            'aria-hidden' => 'true',
            'data-slot' => 'icon',
        ],
        'solid/ui' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 24 24',
            'fill' => 'none',
            'aria-hidden' => 'true',
            'data-slot' => 'icon',
        ],
        'solid/logo' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 200 200',
            'fill' => 'none',
            'aria-hidden' => 'true',
            'data-slot' => 'icon',
        ],
    ];

    /** @var array<string, array<string, array<string, string|array<string>>>> */
    protected static array $loadedIcons = [];

    protected ?string $name = null;
    protected string $size = self::SIZE_NORMAL;
    protected string $type = self::TYPE_OUTLINE;
    protected bool $isHeroicon = true;
    protected array $attributes = [];

    /**
     * Factory for Heroicons
     */
    public static function heroicon(): static
    {
        $instance = new static();
        $instance->isHeroicon = true;
        return $instance;
    }

    /**
     * Factory for custom icons
     */
    public static function icon(): static
    {
        $instance = new static();
        $instance->isHeroicon = false;
        return $instance;
    }

    /**
     * Outline icon (normal 24x24) - Heroicons only
     */
    public function outline(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        $new->size = static::SIZE_NORMAL;
        $new->type = static::TYPE_OUTLINE;
        return $new;
    }

    /**
     * Solid icon (normal 24x24) - Heroicons only
     */
    public function solid(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        $new->size = static::SIZE_NORMAL;
        $new->type = static::TYPE_SOLID;
        return $new;
    }

    /**
     * Mini solid icon (20x20) - Heroicons only
     */
    public function mini(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        $new->size = static::SIZE_MINI;
        $new->type = static::TYPE_SOLID;
        return $new;
    }

    /**
     * Micro solid icon (16x16) - Heroicons only
     */
    public function micro(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        $new->size = static::SIZE_MICRO;
        $new->type = static::TYPE_SOLID;
        return $new;
    }

    /**
     * UI custom icon (24x24) - Custom icons only
     */
    public function ui(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        $new->size = static::SIZE_UI;
        $new->type = static::TYPE_SOLID;
        $new->isHeroicon = false;
        return $new;
    }

    /**
     * Custom logo (200x200) - Custom icons only
     */
    public function logo(string $name): self
    {
        $new = clone $this;
        $new->name = $name;
        $new->size = static::SIZE_LOGO;
        $new->type = static::TYPE_SOLID;
        $new->isHeroicon = false;
        return $new;
    }

    /**
     * Sets the id attribute
     */
    public function id(string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Adds a CSS class
     */
    public function addClass(string ...$classes): self
    {
        $new = clone $this;
        $existing = $new->attributes['class'] ?? '';
        $new->attributes['class'] = trim($existing . ' ' . implode(' ', $classes));
        return $new;
    }

    /**
     * Sets an HTML attribute
     */
    public function attribute(string $name, mixed $value): self
    {
        $new = clone $this;
        $new->attributes[$name] = $value;
        return $new;
    }

    /**
     * Sets plusieurs attributs HTML
     */
    public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $attributes);
        return $new;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function render(): string
    {
        if ($this->name === null) {
            throw new InvalidArgumentException('SVG name is required. Use outline(), solid(), mini(), micro(), ui() or logo() first.');
        }

        $this->validateSizeType();

        $iconData = $this->loadIconData();
        $path = $iconData[$this->name] ?? null;

        if ($path === null) {
            throw new InvalidArgumentException('SVG "' . $this->name . '" not found in ' . $this->type . '/' . $this->size);
        }

        $key = $this->type . '/' . $this->size;
        $baseAttributes = static::$outerSvgAttributes[$key];

        if (is_array($path) === true && isset($path['viewBox']) === true) {
            $viewBox = $path['viewBox'];
            unset($path['viewBox']);
            $baseAttributes['viewBox'] = $viewBox;
        }

        $finalAttributes = array_merge($baseAttributes, $this->attributes);

        $pathContent = is_array($path) === true ? implode("\n", $path) : $path;

        return Html::tag('svg', $pathContent, $finalAttributes)
            ->encode(false)
            ->render();
    }

    protected function validateSizeType(): void
    {
        $validSizes = [
            static::SIZE_NORMAL,
            static::SIZE_MINI,
            static::SIZE_MICRO,
            static::SIZE_UI,
            static::SIZE_LOGO,
        ];
        $validTypes = [
            static::TYPE_OUTLINE,
            static::TYPE_SOLID,
        ];

        if (in_array($this->size, $validSizes, true) === false || in_array($this->type, $validTypes, true) === false) {
            throw new InvalidArgumentException('Invalid size or type');
        }

        if ($this->size !== static::SIZE_NORMAL && $this->type === static::TYPE_OUTLINE) {
            throw new InvalidArgumentException('Outline type is only available for normal size');
        }
    }

    /**
     * @return array<string, string|array<string>>
     */
    protected function loadIconData(): array
    {
        if (isset(static::$loadedIcons[$this->size][$this->type]) === false) {
            $directory = $this->isHeroicon === true ? static::HEROICONS_DIR : static::CUSTOMICONS_DIR;

            $filePath = static::RESOURCES_DIR . DIRECTORY_SEPARATOR . $directory . DIRECTORY_SEPARATOR . $this->size . DIRECTORY_SEPARATOR . $this->type . '.php';

            if (file_exists($filePath) === false) {
                throw new InvalidArgumentException('Icons file not found: ' . $this->type . '/' . $this->size);
            }

            static::$loadedIcons[$this->size][$this->type] = require $filePath;
        }

        return static::$loadedIcons[$this->size][$this->type];
    }
}
