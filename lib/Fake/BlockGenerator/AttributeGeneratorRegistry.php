<?php

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\BlockGenerator\Attribute\AttributeGeneratorInterface;
use InvalidArgumentException;

class AttributeGeneratorRegistry
{
    /**
     * @var array<AttributeGeneratorInterface>
     */
    private array $generators = [];

    /**
     * @param iterable<AttributeGeneratorInterface> $generators
     */
    public function __construct(iterable $generators = [])
    {
        foreach ($generators as $type => $generator) {
            $this->registerGenerator($type, $generator);
        }
    }

    public function registerGenerator(string $type, AttributeGeneratorInterface $generator): void
    {
        $this->generators[$type] = $generator;
    }

    public function getGenerator(string $type): AttributeGeneratorInterface
    {
        if (isset($this->generators[$type])) {
            return $this->generators[$type];
        }

        throw new InvalidArgumentException("No generator for type : $type");
    }
}
