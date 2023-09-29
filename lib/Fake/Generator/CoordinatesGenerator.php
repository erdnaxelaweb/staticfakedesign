<?php

declare(strict_types=1);

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
