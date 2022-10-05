<?php
$name = $_GET['name'];

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->delete(['name' => $name], ['limit' => 0]);   // limit 为 1 时，删除第一条匹配数据
$manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");  
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);
$result = $manager->executeBulkWrite('admin.user', $bulk, $writeConcern);
