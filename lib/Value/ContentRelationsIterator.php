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

use ArrayIterator;

class ContentRelationsIterator implements ContentRelationsIteratorInterface
{
    /**
     * @var ArrayIterator<int, ContentRelation>
     */
    protected ArrayIterator $generatedStack;

    /**
     * @param callable():ContentRelation $generator
     */
    public function __construct(
        protected $generator,
        protected int $limit = 0
    ) {
        $this->generatedStack = new ArrayIterator();
    }


    public function count(): int
    {
        return $this->limit;
    }

    public function current(): ContentRelation
    {
        if (!$this->generatedStack->valid()) {
            $this->generatedStack->append(($this->generator)());
        }

        return $this->generatedStack->current();
    }

    public function next(): void
    {
        $this->generatedStack->next();
    }

    public function key(): mixed
    {
        return $this->generatedStack->key();
    }

    public function valid(): bool
    {
        return $this->generatedStack->count() < $this->limit;
    }

    public function rewind(): void
    {
        $this->generatedStack->rewind();
    }
}
