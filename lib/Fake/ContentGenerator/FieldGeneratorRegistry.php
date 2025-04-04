<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator;

use ErdnaxelaWeb\StaticFakeDesign\Fake\ContentGenerator\Field\FieldGeneratorInterface;
use InvalidArgumentException;

class FieldGeneratorRegistry
{
    /**
     * @var array<FieldGeneratorInterface>
     */
    private array $generators = [];

    /**
     * @param iterable<FieldGeneratorInterface> $generators
     */
    public function __construct(iterable $generators = [])
    {
        foreach ($generators as $type => $generator) {
            $this->registerGenerator($type, $generator);
        }
    }

    public function registerGenerator(string $type, FieldGeneratorInterface $generator): void
    {
        if (!is_callable($generator)) {
            throw new InvalidArgumentException("Generator must be callable");
        }
        $this->generators[$type] = $generator;
    }

    public function getGenerator(string $type): FieldGeneratorInterface
    {
        if (isset($this->generators[$type])) {
            return $this->generators[$type];
        }

        throw new InvalidArgumentException("No generator for type : $type");
    }

    /**
     * @return string[]
     */
    public function getTypes(): array
    {
        return array_keys($this->generators);
    }
}
