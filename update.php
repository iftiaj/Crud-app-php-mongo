<?php

$pData = $_POST;
$bulk = new MongoDB\Driver\BulkWrite;
$bulk->update(
    ['name' => $pData['name']],
    ['$set' => ['phone' => $pData['phone'],'address' => $pData['address']]],
    ['multi' => false, 'upsert' => false]
);

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");  
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
$result = $manager->executeBulkWrite('admin.user', $bulk, $writeConcern);