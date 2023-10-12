<?php
/*
 * staticfakedesignbundle.
 *
 * @package   DesignBundle
 *
 * @author    florian
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

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
