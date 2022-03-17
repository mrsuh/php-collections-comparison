<?php

namespace App\Collection;

class GenericCollection<T> implements \Iterator {

    protected \ArrayIterator $iterator;

    public function __construct()
    {
        $this->iterator = new \ArrayIterator();
    }

    public function append(T $item): void
    {
        $this->iterator->append($item);
    }

    #[\ReturnTypeWillChange]
    public function current(): ?T
    {
        return $this->iterator->current();
    }

    public function next(): void
    {
        $this->iterator->next();
    }

    #[\ReturnTypeWillChange]
    public function key()
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
