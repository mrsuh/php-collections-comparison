<?php

namespace App\Collection;

/**
 * @template T
 */
class AnnotationCollection implements \Iterator
{
    protected \ArrayIterator $iterator;

    public function __construct()
    {
        $this->iterator = new \ArrayIterator();
    }

    /** @param T $item */
    public function append($item): void
    {
        $this->iterator->append($item);
    }

    /** @return T|null */
    public function current(): mixed
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    public function key(): mixed
    {
        return $this->iterator->key();
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
    }
}
