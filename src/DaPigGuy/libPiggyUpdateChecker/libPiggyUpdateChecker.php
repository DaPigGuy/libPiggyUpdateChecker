<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyUpdateChecker;

use DaPigGuy\libPiggyUpdateChecker\tasks\CheckUpdatesTask;
use pocketmine\Server;

class libPiggyUpdateChecker
{
    public static bool $hasInitiated = false;

    public static function init(string $name): void
    {
        if (!self::$hasInitiated) {
            self::$hasInitiated = true;
            Server::getInstance()->getAsyncPool()->submitTask(new CheckUpdatesTask($name));
        }
    }
}