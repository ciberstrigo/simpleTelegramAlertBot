<?php

mb_internal_encoding("UTF-8");
ini_set ('display_errors', 'on');
ini_set ('log_errors', 'on');
ini_set ('display_startup_errors', 'on');
ini_set ('error_reporting', E_ALL);

include "Entity/Interfaces/Entity.php";
include "Variables.php";
include "Telegram.php";
include "Main.php";
include "ResponseReactions/Interfaces/Reaction.php";
include "ResponseReactionsCollection.php";
include "ResponseReactions/DefaultReaction.php";
include "ResponseReactions/HashtagCurrentRequestReaction.php";
include "ResponseReactions/HashtagBugReaction.php";
include "TaskManager.php";
include "Entity/Task.php";


return TelegramAlertBot\Main::main();