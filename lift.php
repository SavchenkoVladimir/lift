<?php

require "vendor/autoload.php";

use App\Src\Router;

$router = new Router($argv);
$router->execute();
