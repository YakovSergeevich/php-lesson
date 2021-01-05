<?php

$db = new PDO('pgsql:dbname=test;host=lesson-postgres', 'yakov', 123);
$query = "SELECT table_name FROM information_schema.tables WHERE table_schema='public'";
$statement = $db->prepare($query);
$bool = $statement->execute();
$result = $statement->fetchAll(2);
echo '<pre>';
print_r($result);
echo '<pre>';