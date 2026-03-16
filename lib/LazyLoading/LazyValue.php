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

class LazyValue
{
    /**
     * @param callable(mixed...): mixed $initializer
     */
    public function __construct(
        protected $initializer
    ) {
    }

    /**
     * @param mixed ...$args
     */
    public function __invoke(...$args): mixed
    {
        return ($this->initializer)(...$args);
    }
}
