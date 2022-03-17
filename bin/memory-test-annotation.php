<?php

require_once __DIR__ . '/../src/Entity/Item.php';
require_once __DIR__ . '/../src/Collection/AnnotationCollection.php';
require_once __DIR__ . '/../src/Factory/AnnotationCollectionFactory.php';
require_once __DIR__ . '/../vendor/mrsuh/php-var-sizeof/src/VarInfo.php';
require_once __DIR__ . '/../vendor/mrsuh/php-var-sizeof/functions/var_sizeof.php';
require_once __DIR__ . '/../vendor/mrsuh/php-var-sizeof/functions/var_class_sizeof.php';

use App\Entity\Item;
use App\Factory\AnnotationCollectionFactory;

$count = (int)$argv[1];

new ReflectionClass(AnnotationCollectionFactory::class);
new ReflectionClass(Item::class);

$memoryUsageStartBytes = memory_get_usage();
$collection            = AnnotationCollectionFactory::get();
for ($i = 0; $i < $count; $i++) {
    $collection->append(new Item());
}
$memoryUsageBytes = memory_get_usage() - $memoryUsageStartBytes;

echo json_encode(['memory_get_usage' => $memoryUsageBytes, 'sizeof' => var_sizeof($collection), 'class_sizeof' => var_class_sizeof($collection)]);


