<?php
require './translate/Autoload.class.php';

$base_path = __DIR__;
Autoload::register($base_path);

$translate = new \YouDaoTranslateApi\translate\utils\Translate();

$translate->run($argv);


