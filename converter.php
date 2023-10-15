<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\Main;

$main = new Main();
$main->run($argv);