<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyUpdateChecker;

use DaPigGuy\PiggyFactions\tasks\CheckUpdatesTask;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class libPiggyUpdateChecker
{
    public static bool $hasInitiated = false;

    public static function init(Plugin $plugin): void
    {
        if (!self::$hasInitiated) {
            self::$hasInitiated = true;
            Server::getInstance()->getAsyncPool()->submitTask(new CheckUpdatesTask($plugin));
        }
    }
}