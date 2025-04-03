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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @template TKey of array-key
 * @template T
 * @extends ArrayCollection<TKey, T>
 */
class Collection extends ArrayCollection
{
    /**
     * @param T $value
     */
    public function __set(string $name, $value): void
    {
        $this->set($name, $value);
    }

    /**
     * @return T
     */
    public function __get(string $name)
    {
        return $this->get($name);
    }
}
