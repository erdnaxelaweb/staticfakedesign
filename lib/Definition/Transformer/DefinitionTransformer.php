<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer;

use ErdnaxelaWeb\StaticFakeDesign\Definition\DefinitionInterface;
use InvalidArgumentException;

/**
 * @phpstan-import-type definitionHash from DefinitionTransformerInterface
 */
class DefinitionTransformer
{
    /**
     * @var \ErdnaxelaWeb\StaticFakeDesign\Definition\Transformer\DefinitionTransformerInterface[]
     */
    protected array $transformers;

    /**
     * @param iterable<DefinitionTransformerInterface> $transformers
     */
    public function __construct(
        iterable $transformers = []
    ) {
        $this->transformers = [];
        foreach ($transformers as $type => $transformer) {
            $this->registerTransformer($type, $transformer);
        }
    }

    public function registerTransformer(string $type, DefinitionTransformerInterface $transformer): void
    {
        $this->transformers[$type] = $transformer;
    }

    public function getTransformer(string $type): DefinitionTransformerInterface
    {
        if (!isset($this->transformers[$type])) {
            throw new InvalidArgumentException("No transformer found for type $type");
        }
        return $this->transformers[$type];
    }

    /**
     * @param definitionHash $hash
     */
    public function fromHash(string $type, array $hash): DefinitionInterface
    {
        $transformer = $this->getTransformer($type);
        return $transformer->fromHasH($hash);
    }

    /**
     * @return definitionHash
     */
    public function toHash(string $type, DefinitionInterface $definition): array
    {
        $transformer = $this->getTransformer($type);
        return $transformer->toHash($definition);
    }
}
