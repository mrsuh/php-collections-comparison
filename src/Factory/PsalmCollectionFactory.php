<?php

namespace App\Factory;

use App\Collection\PsalmCollection;
use App\Entity\Item;

class PsalmCollectionFactory
{
    /** @return PsalmCollection<Item> */
    public static function get()
    {
        return new PsalmCollection();
    }
}
