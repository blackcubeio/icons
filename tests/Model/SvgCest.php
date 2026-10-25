<?php

declare(strict_types=1);

/**
 * @copyright 2010-2026 Blackcube - Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace Blackcube\Icons\Tests\Model;

use Blackcube\Icons\Svg;
use Blackcube\Icons\Tests\Support\ModelTester;
use InvalidArgumentException;

/**
 * Icon rendering: ask for an icon, look at the SVG produced.
 *
 * @copyright 2010-2026 Blackcube - Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class SvgCest
{
    public function heroiconSolid(ModelTester $I): void
    {
        $I->wantTo('render a solid icon of the normal size');

        $html = Svg::heroicon()->solid('eye')->render();

        $I->assertStringStartsWith('<svg', $html);
        $I->assertStringContainsString('viewBox="0 0 24 24"', $html);
        $I->assertStringContainsString('fill="currentColor"', $html);
        $I->assertStringContainsString('aria-hidden="true"', $html);
        $I->assertStringContainsString('<path', $html);
    }

    public function heroiconOutline(ModelTester $I): void
    {
        $I->wantTo('render an outline icon');

        $html = Svg::heroicon()->outline('arrow-up-tray')->render();

        $I->assertStringContainsString('fill="none"', $html);
        $I->assertStringContainsString('stroke="currentColor"', $html);
        $I->assertStringContainsString('stroke-width="1.5"', $html);
    }

    public function heroiconMini(ModelTester $I): void
    {
        $I->wantTo('render a mini icon, drawn on twenty pixels');

        $html = Svg::heroicon()->mini('exclamation-circle')->render();

        $I->assertStringContainsString('viewBox="0 0 20 20"', $html);
    }

    public function heroiconMicro(ModelTester $I): void
    {
        $I->wantTo('render a micro icon, drawn on sixteen pixels');

        $html = Svg::heroicon()->micro('check')->render();

        $I->assertStringContainsString('viewBox="0 0 16 16"', $html);
    }

    public function customIcon(ModelTester $I): void
    {
        $I->wantTo('render a custom icon');

        $html = Svg::icon()->ui('checkbox')->render();

        $I->assertStringStartsWith('<svg', $html);
        $I->assertStringContainsString('<path', $html);
    }

    public function addedClasses(ModelTester $I): void
    {
        $I->wantTo('set my own classes on the icon');

        $html = Svg::heroicon()->solid('eye')->addClass('size-5', 'text-danger-500')->render();

        $I->assertStringContainsString('size-5', $html);
        $I->assertStringContainsString('text-danger-500', $html);
    }

    public function noClassByDefault(ModelTester $I): void
    {
        $I->wantTo('check that the icon sets no class on its own');

        $html = Svg::heroicon()->solid('eye')->render();

        $I->assertStringNotContainsString('class=', $html);
    }

    public function customAttributes(ModelTester $I): void
    {
        $I->wantTo('set an attribute on the icon');

        $html = Svg::heroicon()->solid('eye')->attribute('data-role', 'decoration')->render();

        $I->assertStringContainsString('data-role="decoration"', $html);
    }

    public function unknownIcon(ModelTester $I): void
    {
        $I->wantTo('be told when the requested icon does not exist');

        $thrown = false;

        try {
            Svg::heroicon()->solid('this-icon-does-not-exist')->render();
        } catch (InvalidArgumentException $exception) {
            $thrown = true;
            $I->assertStringContainsString('this-icon-does-not-exist', $exception->getMessage());
        }

        $I->assertTrue($thrown, 'an unknown icon must throw an exception');
    }

    public function missingName(ModelTester $I): void
    {
        $I->wantTo('be told when no icon is requested');

        $thrown = false;

        try {
            Svg::heroicon()->render();
        } catch (InvalidArgumentException) {
            $thrown = true;
        }

        $I->assertTrue($thrown, 'rendering without a name must throw an exception');
    }

    public function allSetsAreComplete(ModelTester $I): void
    {
        $I->wantTo('check that the four Heroicons sets are loaded');

        $expected = [
            'heroicons/normal/outline' => 324,
            'heroicons/normal/solid' => 324,
            'heroicons/mini/solid' => 324,
            'heroicons/micro/solid' => 316,
        ];

        foreach ($expected as $set => $count) {
            $file = dirname(__DIR__, 2) . '/src/resources/' . $set . '.php';
            $I->assertFileExists($file);
            $I->assertCount($count, require $file, $set);
        }
    }
}
