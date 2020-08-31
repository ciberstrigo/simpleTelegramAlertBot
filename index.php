<?php

mb_internal_encoding("UTF-8");

include "Variables.php";
include "Telegram.php";
include "Main.php";

return TelegramAlertBot\Main::main();