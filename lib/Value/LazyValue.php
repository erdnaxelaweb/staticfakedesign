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

class LazyValue
{
    /**
     * @param callable(): mixed $initializer
     */
    public function __construct(
        protected $initializer
    ) {
    }

    public function __invoke(): mixed
    {
        return ($this->initializer)();
    }
}
