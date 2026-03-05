<?php


declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\LazyLoading;

use Symfony\Component\VarExporter\Internal\Registry;

trait LazyObjectTrait
{
    /**
     * @var array <string, mixed>
     */
    private array $properties;


    public function __get(string $name): mixed
    {
        return $this->getPropertyValue($name);
    }

    public function __isset(string $name): bool
    {
        return isset($this->properties[$name]);
    }

    /**
     * @param array<string, mixed>    $properties
     * @param array<string, callable> $initializers
     *
     * @return static
     * @throws \ReflectionException
     */
    public static function instantiate(
        array $properties,
        array $initializers
    ): object {
        $reflector = Registry::$reflectors[static::class] ??= Registry::getClassReflector(static::class);
        $instance = $reflector->newInstanceWithoutConstructor();

        $instance->properties = $properties;
        foreach ($initializers as $property => $initializer) {
            $instance->properties[$property] = new LazyValue($initializer);
        }
        return $instance;
    }

    protected function getPropertyValue(string $name): mixed
    {
        if ($this->properties[$name] instanceof LazyValue) {
            return $this->properties[$name] = $this->properties[$name]($this);
        }
        return $this->properties[$name];
    }
}
