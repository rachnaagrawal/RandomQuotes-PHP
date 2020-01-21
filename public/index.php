<?php
require '../vendor/autoload.php';

$app = (new Routes())->get();
$app->run();
