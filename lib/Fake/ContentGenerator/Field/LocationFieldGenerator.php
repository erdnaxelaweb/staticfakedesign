<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field;

use ErdnaxelaWeb\StaticFakeDesign\Fake\Generator\CoordinatesGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;

class LocationFieldGenerator extends AbstractFieldGenerator
{
    public function __construct(
        protected CoordinatesGenerator $coordinatesGenerator
    ) {
    }

    public function __invoke(): Coordinates
    {
        return ($this->coordinatesGenerator)();
    }
}
