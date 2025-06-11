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
     * @var array<string, array<string, DefinitionInterface>>
     */
    protected array $transformedDefinitions = [];

    /**
     * @param array<string, array<string, array<string, mixed>>> $definitions
     */
    public function __construct(
        protected DefinitionTransformer $definitionTransformer,
        protected array $definitions = []
    ) {
    }

    /**
     * @param array<string, array<string, mixed>> $definitionsHashes
     */
    public function registerDefinitions(string $type, array $definitionsHashes): void
    {
        if (!isset($this->definitions[$type])) {
            $this->definitions[$type] = [];
        }
        foreach ($definitionsHashes as $identifier => $definitionsHash) {
            $this->registerDefinition($type, $identifier, $definitionsHash);
        }
    }

    /**
     * @param array<string, mixed> $definitionHash
     */
    public function registerDefinition(string $type, string $identifier, array $definitionHash): void
    {
        $this->definitions[$type][$identifier] = $definitionHash;
    }

    /**
     * @return array<string, array<string, array<string, mixed>>>
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
        return array_keys($this->getDefinitionsHashesByType($type));
    }

    /**
     * @template T of DefinitionInterface
     * @param class-string<T> $definitionClass
     *
     * @return array<T>
     * @throws \ErdnaxelaWeb\StaticFakeDesign\Exception\DefinitionTypeNotFoundException
     */
    public function getDefinitionsByType(string $definitionClass): array
    {
        if (class_exists($definitionClass)) {
            $type = constant($definitionClass . '::DEFINITION_TYPE');
        } else {
            $type = $definitionClass;
        }

        $definitionsHashes = $this->getDefinitionsHashesByType($type);
        $definitions = [];
        foreach ($definitionsHashes as $identifier => $definitionsHash) {
            $definitions[$identifier] = $this->innerGetDefinition($type, $identifier, $definitionsHash);
        }
        return $definitions;
    }

    /**
     * @template T of DefinitionInterface
     * @param class-string<T> $definitionClass
     *
     * @return T
     * @throws \ErdnaxelaWeb\StaticFakeDesign\Exception\DefinitionTypeNotFoundException
     */
    public function getDefinition(string $definitionClass, string $identifier): DefinitionInterface
    {
        if (class_exists($definitionClass)) {
            $type = constant($definitionClass . '::DEFINITION_TYPE');
        } else {
            $type = $definitionClass;
        }

        $definitionsHashes = $this->getDefinitionsHashesByType($type);
        if (!isset($definitionsHashes[$identifier])) {
            throw new DefinitionNotFoundException($type, $identifier);
        }

        return $this->innerGetDefinition($type, $identifier, $definitionsHashes[$identifier]);
    }

    /**
     * @throws \ErdnaxelaWeb\StaticFakeDesign\Exception\DefinitionTypeNotFoundException
     * @return array<string, array<string, mixed>>
     */
    protected function getDefinitionsHashesByType(mixed $type): array
    {
        if (!isset($this->definitions[$type])) {
            throw new DefinitionTypeNotFoundException($type);
        }
        return $this->definitions[$type];
    }

    /**
     * @param array<string, mixed>  $definitionHash
     */
    protected function innerGetDefinition(string $type, string $identifier, array $definitionHash): DefinitionInterface
    {
        $key = $this->getDefinitionCacheKey($type, $identifier);
        if (!isset($this->transformedDefinitions[$key])) {
            $transformedDefinition = $this->buildDefinition($type, $identifier, $definitionHash);
            $this->transformedDefinitions[$key] = $transformedDefinition;
        }
        return $this->transformedDefinitions[$key];
    }

    /**
     * @param array<string, mixed>  $definitionHash
     */
    protected function buildDefinition(string $type, string $identifier, array $definitionHash): DefinitionInterface
    {
        return $this->definitionTransformer->fromHash(
            $type,
            [
                'identifier' => $identifier,
                'hash' => $definitionHash,
            ]
        );
    }

    protected function getDefinitionCacheKey(string $type, string $identifier): string
    {
        return sprintf('%s-%s', $type, $identifier);
    }
}
