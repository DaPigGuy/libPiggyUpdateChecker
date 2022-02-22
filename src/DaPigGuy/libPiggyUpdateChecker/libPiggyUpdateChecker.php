<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyUpdateChecker;

use DaPigGuy\libPiggyUpdateChecker\tasks\CheckUpdatesTask;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class libPiggyUpdateChecker
{
    public static function init(string $name): void
    {
        $plugin = self::getPlugin($name);
        if ($plugin) Server::getInstance()->getAsyncPool()->submitTask(new CheckUpdatesTask($name, $plugin->getDescription()->getVersion()));
    }

    public static function getPlugin(string $name): ?Plugin
    {
        $plugin = Server::getInstance()->getPluginManager()->getPlugin($name);
        if (!$plugin) {
            Server::getInstance()->getLogger()->error("Plugin " . $name . " not found.");
            return null;
        }
        return $plugin;
    }
}