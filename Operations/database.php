<?php
//Single-location database connection. Called when database interaction is needed.
$db = new PDO('mysql:host=localhost;dbname=parks;charset=utf8mb4', 'root', '');
?>