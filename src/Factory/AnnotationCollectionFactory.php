<?php

namespace App\Factory;

use App\Collection\AnnotationCollection;
use App\Entity\Item;

class AnnotationCollectionFactory
{
    /** @return AnnotationCollection<Item> */
    public static function get()
    {
        return new AnnotationCollection();
    }
}
