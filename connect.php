<?php
    // connect to mongo

    $m = new MongoDB\Driver\Manager("mongodb://localhost:27017");

    echo "Connection to database successful";

    // select a database
if (!empty($m->db_php_mongo)) {
    $db = $m->db_php_mongo;
}

    echo "Database db_php_mongo selected";




