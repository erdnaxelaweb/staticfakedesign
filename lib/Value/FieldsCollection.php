<?php

declare(strict_types=1);

/*
 * Static Fake Design Bundle.
 *
 * @author    Florian ALEXANDRE
 * @copyright 2023-present Florian ALEXANDRE
 * @license   https://github.com/erdnaxelaweb/staticfakedesign/blob/main/LICENSE
 */

namespace ErdnaxelaWeb\StaticFakeDesign\Value;

use BadMethodCallException;

/**
 * @template TKey of array-key
 * @template T
 * @extends Collection<TKey, T>
 */
class FieldsCollection extends Collection
{
    /**
     * @param array<mixed> $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        $value = $this->get($name);
        if (is_callable($value)) {
            return call_user_func_array($value, $arguments);
        }
        throw new BadMethodCallException(sprintf('Method %s does not exist', $name));
    }
}
