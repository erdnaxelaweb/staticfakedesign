<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Fake;

use ErdnaxelaWeb\StaticFakeDesign\Component\ComponentParameterTypeParser;
use ErdnaxelaWeb\StaticFakeDesign\Value\ComponentParameterType;

class ChainGenerator
{
    /**
     * @var array<GeneratorInterface>
     */
    protected array $generators = [];

    /**
     * @param iterable<GeneratorInterface> $generators
     */
    public function __construct(
        protected FakerGenerator $fakerGenerator,
        protected ComponentParameterTypeParser $componentParameterTypeParser,
        protected bool           $enableFakeGeneration,
        iterable                 $generators = [],
    ) {
        foreach ($generators as $type => $generator) {
            $this->registerGenerator($type, $generator);
        }
    }

    public function isFakeGenerationEnabled(): bool
    {
        return $this->enableFakeGeneration;
    }

    public function registerGenerator(string $type, GeneratorInterface $generator): void
    {
        $this->generators[$type] = $generator;
    }

    /**
     * @param array<mixed> $parameters
     */
    public function generateFake(string $type, array $parameters = []): mixed
    {
        $generator = $this->generators[$type] ?? [$this->fakerGenerator, $type];
        return $this->isFakeGenerationEnabled() ? call_user_func_array($generator, $parameters) : null;
    }

    /**
     * @param array<mixed> $parameters
     *
     * @return array<mixed>
     */
    public function generateFakeArray(?int $count, string $type, array $parameters = []): array
    {
        $count = $count ?? rand(1, 10);
        $values = [];
        for ($i = 0; $i < $count; ++$i) {
            $values[] = $this->generateFake($type, $parameters);
        }
        return $values;
    }

    /**
     * @throws \JsonException
     */
    public function generateFromTypeExpression(string $typeExpression): mixed
    {
        $type = $this->componentParameterTypeParser->fromString($typeExpression);
        return $this->generateFromType($type);
    }

    public function generateFromType(ComponentParameterType $type): mixed
    {
        if ($type->isArray()) {
            return $this->generateFakeArray($type->getArraySize(), $type->getType(), $type->getParameters());
        } else {
            return $this->generateFake($type->getType(), $type->getParameters());
        }
    }
}
