<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute;

use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;

abstract class AbstractAttributeGenerator extends AbstractGenerator implements AttributeGeneratorInterface
{
    public function getForcedValue(mixed $value): mixed
    {
        return $value;
    }
}
