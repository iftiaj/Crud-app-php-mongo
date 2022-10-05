<?php

$postData = $_POST;


$bulk = new MongoDB\Driver\BulkWrite;
$document = ['_id' => new MongoDB\BSON\ObjectID, 'name' => $postData['name'], 'address'=> $postData['address'], 'phone'=> $postData['phone']];

$_id= $bulk->insert($document);

var_dump($_id);

$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");  
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
$result = $manager->executeBulkWrite('admin.user', $bulk, $writeConcern);