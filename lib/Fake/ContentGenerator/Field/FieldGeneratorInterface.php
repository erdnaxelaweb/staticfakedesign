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
use ErdnaxelaWeb\StaticFakeDesign\Fake\GeneratorInterface;

interface FieldGeneratorInterface extends GeneratorInterface
{
    public function getForcedValue(mixed $value): mixed;

    /**
     * Return an array where the index is the relation type and the value the possible destination content types
     *
     * @return array<int, string[]>
     */
    public function getRelations(DefinitionOptions $options): array;
}
