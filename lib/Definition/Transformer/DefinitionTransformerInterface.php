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

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;

/**
 * @phpstan-type definitionHash array{identifier: string, hash: array<string, mixed>}
 */
interface DefinitionTransformerInterface
{
    /**
     * Transforms a hash into a definition.
     *
     * @param definitionHash $hash
     */
    public function fromHash(array $hash): DefinitionInterface;

    /**
     * Transforms a definition into a hash.
     *
     * @return definitionHash
     */
    public function toHash(DefinitionInterface $definition): array;
}
