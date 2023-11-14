<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/Kernel/function.php';

date_default_timezone_set('Asia/Shanghai');

use App\App;

$app = new App();
$app->run();