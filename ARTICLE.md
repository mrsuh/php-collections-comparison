# Comparing PHP Collections

Let's imagine we want to store a `collection` of `Item` objects
```php
<?php

namespace App\Entity;

class Item {
    public string $name = '';
    public int $value = 0;
}
```

When we work with this collection we want to:
* PHP make type checks to be sure collection store only `Item` objects
* IDE make prompts about `Item` objects in collection
* Static analyses tool can find typehint errors

I want to compare:
* [array](https://www.php.net/manual/en/language.types.array.php)
* [Psalm annotation templates](https://psalm.dev/docs/annotating_code/templated_annotations)
* [Monomorphic generics](https://github.com/mrsuh/php-generics)
* [Type-erased generics](https://github.com/mrsuh/php-generics)

## Usage

### Array
```php
<?php

/** @var Item[] $collection */
$collection = [];
$collection[] = new Item();

/**
 * @param Item[] $collection
 */
function test(array $collection): array {}
```

#### pros
* easy to realise
* IDE make prompts about `Item` objects in collection
* Static analyses tool can find typehint errors
#### cons
* PHP make type checks to be sure collection store only `Item` objects

### Psalm annotations
```php
<?php

/**
 * @template T
 */
class Collection implements \Iterator
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
}
```

```php
<?php
/** @var Collection<Item> $collection */
$collection = new Collection();
$collection->append(new Item());

/**
 * @param Collection<Item> $data
 * @return Collection<Item>
 */
function test(Collection $data): Collection {}
```
#### pros
* IDE make prompts about `Item` objects in collection
* Static analyses tool can find typehint errors
#### cons
* PHP make type checks to be sure collection store only `Item` objects

### Monomorphic generics

```php
<?php

class Collection<T> implements \Iterator
{
    protected \ArrayIterator $iterator;

    public function __construct()
    {
        $this->iterator = new \ArrayIterator();
    }

    public function append(T $item): void
    {
        $this->iterator->append($item);
    }

    public function current(): ?T
    {
        return $this->iterator->current();
    }
}
```

```php
<?php

$collection = new Collection<Item>;
$collection->append(new Item());

function test(Collection<Item> $data): Collection<Item> {}
```

#### pros
* PHP make type checks to be sure collection store only `Item` objects
#### cons
* Static analyses tool can find typehint errors
* IDE make prompts about `Item` objects in collection

### Type erased generics

```php
<?php

class Collection<T> implements \Iterator
{
    protected \ArrayIterator $iterator;

    public function __construct()
    {
        $this->iterator = new \ArrayIterator();
    }

    public function append(T $item): void
    {
        $this->iterator->append($item);
    }

    public function current(): ?T
    {
        return $this->iterator->current();
    }
}
```

```php
<?php

$collection = new Collection<Item>;
$collection->append(new Item());

function test(Collection<Item> $data): Collection<Item> {}
```

#### cons
* PHP make type checks to be sure collection store only `Item` objects
* Static analyses tool can find typehint errors
* IDE make prompts about `Item` objects in collection

## Memory

Memory test is very simple.
We create `$collection` and put into it `Item` objects `count` times.
For measurement, we use [var_sizeof](https://github.com/mrsuh/php-var-sizeof) and `memory_get_usage()`.

#### Items in collection: 0
| type                  | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-----------------------|-------------------------|-------------------|-------------------------|
| array(count: 0)       | 0                       | 336               | 0                       |
| annotation(count: 0)  | 1515                    | 544               | 240                     |
| monomorphic(count: 0) | 1528                    | 544               | 240                     |
| type-erased(count: 0) | 1512                    | 544               | 240                     |

#### Items in collection: 100
| type                    | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|-------------------------|-------------------------|-------------------|-------------------------|
| array(count: 100)       | 0                       | 7728              | 12248                   |
| annotation(count: 100)  | 1515                    | 7936              | 12432                   |
| monomorphic(count: 100) | 1528                    | 7936              | 12432                   |
| type-erased(count: 100) | 1512                    | 7936              | 12432                   |

#### Items in collection: 1000
| type                     | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|--------------------------|-------------------------|-------------------|-------------------------|
| array(count: 1000)       | 0                       | 72464             | 76920                   |
| annotation(count: 1000)  | 1515                    | 72672             | 77104                   |
| monomorphic(count: 1000) | 1528                    | 72672             | 77104                   |
| type-erased(count: 1000) | 1512                    | 72672             | 77104                   |

#### Items in collection: 10000
| type                      | var_class_sizeof(bytes) | var_sizeof(bytes) | memory_get_usage(bytes) |
|---------------------------|-------------------------|-------------------|-------------------------|
| array(count: 10000)       | 0                       | 822224            | 1051320                 |
| annotation(count: 10000)  | 1515                    | 822432            | 1051560                 |
| monomorphic(count: 10000) | 1528                    | 822432            | 1051560                 |
| type-erased(count: 10000) | 1512                    | 822432            | 1051560                 |

`Array` has lowest memory usage and other has equal.

## Performance

For measure performance I used [phpbench](https://github.com/phpbench/phpbench).
I think the only one difference between all solutions is typehint. So I decided to try measure it.
How much faster will work code with/without typehint?

```bash
PHPBench (1.2.3) running benchmarks...
with configuration file: /app/phpbench.json
with PHP version 8.1.2, xdebug ❌, opcache ❌

\App\Tests\TimeBench

    benchWithoutType........................R1 I42 - Mo0.067μs (±0.71%)
    benchWithArrayType......................R3 I70 - Mo0.067μs (±0.88%)
    benchWithClassType......................R1 I46 - Mo0.077μs (±0.83%)

Subjects: 3, Assertions: 0, Failures: 0, Errors: 0
+-----------+--------------------+-----+--------+-----+-----------+---------+--------+
| benchmark | subject            | set | revs   | its | mem_peak  | mode    | rstdev |
+-----------+--------------------+-----+--------+-----+-----------+---------+--------+
| TimeBench | benchWithoutType   |     | 100000 | 100 | 680.912kb | 0.067μs | ±0.71% |
| TimeBench | benchWithArrayType |     | 100000 | 100 | 680.912kb | 0.067μs | ±0.88% |
| TimeBench | benchWithClassType |     | 100000 | 100 | 680.912kb | 0.077μs | ±0.83% |
+-----------+--------------------+-----+--------+-----+-----------+---------+--------+
```

If tests correct there is no big difference between function with and without typehint.

## Conclusions

PHP doesn't support generics syntax and IDE can't make prompts about objects in collection, 
but if you want PHP make checks in runtime you may test [php-generics](https://github.com/mrsuh/php-generics) library.
If you use only simple collections with number index you can use `array` - it is very fast and take low memory.
I think for now the best solution is combination `array` with annotations for simple collections and [Psalm annotation templates](https://psalm.dev/docs/annotating_code/templated_annotations) for complex objects.
