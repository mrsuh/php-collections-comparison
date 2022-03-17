<?php

namespace App\Tests;

use App\Entity\Item;

class TypHintBench
{
    const ITERATIONS = 10000;

    private ?Item  $item  = null;
    private ?array $array = null;

    public function setUp()
    {
        $this->item  = new Item();
        $this->array = [];
    }

    /**
     * @BeforeMethods({"setUp"})
     * @Revs(1000)
     * @Iterations(100)
     * @RetryThreshold(1.0)
     */
    public function benchWithoutType()
    {
        for ($i = 0; $i < self::ITERATIONS; $i++) {
            self::withoutType($this->array);
        }
    }

    /**
     * @BeforeMethods({"setUp"})
     * @Revs(1000)
     * @Iterations(100)
     * @RetryThreshold(1.0)
     */
    public function benchWithArrayType()
    {
        for ($i = 0; $i < self::ITERATIONS; $i++) {
            self::withArrayType($this->array);
        }
    }

    /**
     * @BeforeMethods({"setUp"})
     * @Revs(1000)
     * @Iterations(100)
     * @RetryThreshold(1.0)
     */
    public function benchWithMixedType()
    {
        for ($i = 0; $i < self::ITERATIONS; $i++) {
            self::withMixedType($this->array);
        }
    }

    /**
     * @BeforeMethods({"setUp"})
     * @Revs(1000)
     * @Iterations(100)
     * @RetryThreshold(1.0)
     */
    public function benchWithClassType()
    {
        for ($i = 0; $i < self::ITERATIONS; $i++) {
            self::withClassType($this->item);
        }
    }

    private static function withoutType($item)
    {
        return $item;
    }

    private static function withArrayType(array $item)
    {
        return $item;
    }

    private static function withClassType(Item $item)
    {
        return $item;
    }

    private static function withMixedType(mixed $item)
    {
        return $item;
    }
}
