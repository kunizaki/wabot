<?php
$configs = json_decode(file_get_contents(__DIR__ . "/../configs.json"), true);

$conn = mysqli_connect(
    $configs['dbhost'],
    $configs['dbuser'],
    $configs['dbpass'],
    $configs['dbname']
) or die('Database connection failed. Please check configs.json file!');

$base_url = $configs['base_url'];
date_default_timezone_set($configs['timezone']);
