<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Configuration;

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DefinitionTransformer;
use ErdnaxelaWeb\StaticFakeDesign\Exception\DefinitionNotFoundException;
use ErdnaxelaWeb\StaticFakeDesign\Exception\DefinitionTypeNotFoundException;

class DefinitionManager
{
    /**
     * @var array <string, array<string, DefinitionInterface>>
     */
    protected array $definitions = [];

    public function __construct(
        protected DefinitionTransformer $definitionTransformer,
    ) {
    }

    /**
     * @param array<string, array<string, mixed>> $definitions
     */
    public function registerDefinitions(string $type, array $definitions): void
    {
        foreach ($definitions as $identifier => $definition) {
            $this->registerDefinition($type, $identifier, $definition);
        }
    }

    /**
     * @param array<string, mixed> $definition
     */
    public function registerDefinition(string $type, string $identifier, array $definition): void
    {
        $this->definitions[$type][$identifier] = $this->definitionTransformer->fromHash(
            $type,
            [
                'identifier' => $identifier,
                'hash' => $definition,
            ]
        );
    }

    /**
     * @return array<string, array<string, DefinitionInterface>>
     */
    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * @return array<string>
     */
    public function getDefinitionsIdentifierByType(string $type): array
    {
        return array_keys($this->definitions[$type]);
    }

    /**
     * @template T of DefinitionInterface
     * @param class-string<T> $definitionClass
     *
     * @return array<T>
     */
    public function getDefinitionsByType(string $definitionClass): array
    {
        $type = constant($definitionClass . '::DEFINITION_TYPE');

        if (!isset($this->definitions[$type])) {
            throw new DefinitionTypeNotFoundException($type);
        }

        return $this->definitions[$type];
    }

    /**
     * @template T of DefinitionInterface
     * @param class-string<T> $definitionClass
     *
     * @return T
     */
    public function getDefinition(string $definitionClass, string $identifier): DefinitionInterface
    {
        $type = constant($definitionClass . '::DEFINITION_TYPE');

        if (!isset($this->definitions[$type])) {
            throw new DefinitionTypeNotFoundException($type);
        }

        if (!isset($this->definitions[$type][$identifier])) {
            throw new DefinitionNotFoundException($type, $identifier);
        }

        return $this->definitions[$type][$identifier];
    }
}
