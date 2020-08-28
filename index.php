<?php

include "vendor/autoload.php";

use TelegramAlertBot\Main;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

Main::main();