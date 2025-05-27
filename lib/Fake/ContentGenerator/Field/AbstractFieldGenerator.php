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

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionOptions;
use ErdnaxelaWeb\StaticFakeDesign\Fake\AbstractGenerator;

abstract class AbstractFieldGenerator extends AbstractGenerator implements FieldGeneratorInterface
{
    public function getForcedValue(mixed $value): mixed
    {
        return $value;
    }

    public function getRelations(DefinitionOptions $options): array
    {
        return [];
    }
}
