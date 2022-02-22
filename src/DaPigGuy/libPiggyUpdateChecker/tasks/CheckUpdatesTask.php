<?php

declare(strict_types=1);

namespace DaPigGuy\libPiggyUpdateChecker\tasks;

use pocketmine\plugin\ApiVersion;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\Internet;

class CheckUpdatesTask extends AsyncTask
{
    public function __construct(private String $name)
    {
    }

    public function onRun(): void
    {
        $result = Internet::getURL("https://poggit.pmmp.io/releases.min.json?name=" . $this->name, 10, [], $error);
        $this->setResult([$result?->getBody(), $error]);
    }

    public function onCompletion(): void
    {
        $plugin = Server::getInstance()->getPluginManager()->getPlugin($this->name);
        [$body, $error] = $this->getResult();
        if ($error) {
            $plugin->getLogger()->warning("Auto-update check failed.");
            $plugin->getLogger()->debug($error);
        } else {
            $versions = json_decode($body, true);
            if ($versions) foreach ($versions as $version) {
                if (version_compare($plugin->getDescription()->getVersion(), $version["version"]) === -1) {
                    if (ApiVersion::isCompatible(Server::getInstance()->getApiVersion(), $version["api"][0])) {
                        $plugin->getLogger()->info($this->name . " v" . $version["version"] . " is available for download at " . $version["artifact_url"] . "/" . $this->name . ".phar");
                        break;
                    }
                }
            }
        }
    }
}