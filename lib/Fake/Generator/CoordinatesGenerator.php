<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\Generator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;
use ErdnaxelaWeb\StaticFakeDesign\Value\Coordinates;

class CoordinatesGenerator extends AbstractGenerator
{
    public function __invoke(): Coordinates
    {
        return new Coordinates(
            $this->fakerGenerator->latitude(),
            $this->fakerGenerator->longitude(),
            $this->fakerGenerator->address()
        );
    }
}
