<?php 
include '\..\proj230\Pages\head.php';
$db = new PDO('mysql:host=localhost;dbname=parks;charset=utf8mb4', 'root', 'password');
foreach($db->query('SELECT * FROM items') as $row) {
    echo $row['parkCode'].' '.$row['Name']; //etc...
}
echo 'Hello World'; ?>