<?php

namespace App\Factory;

use App\Collection\GenericCollection;
use App\Entity\Item;

class GenericCollectionFactory
{
    public static function get(): GenericCollection<Item>
    {
        return new GenericCollection<Item>();
    }
}
