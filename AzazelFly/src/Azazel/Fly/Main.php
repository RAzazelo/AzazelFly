<?php

namespace Azazel\Fly;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;


class FlyCommand extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        if(!$player->isCreative()){
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->sendMessage("§bServer §8»§7 Dein Flugmodus wurde deaktiviert.");
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "fly") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("fly.command")) {
                    if ($sender->getGamemode() !== 1) {
                        if ($sender->getAllowFlight() === false) {
                            $sender->setAllowFlight(true);
                            $sender->sendMessage("§bServer §8» §7Dein Flugmodus wurde aktiviert.");
                        } else {
                            $sender->setAllowFlight(false);
                            $sender->sendMessage("§bServer §8»§c Dein Flugmodus wurde deaktiviert.");
                        }
                    } else {
                        $sender->sendMessage("§bServer §8»§c Dieser Befehl funktioniert nur im Überlebensmodus.");
                    }
                } else {
                    $sender->sendMessage("§bServer §8»§c Du hast nicht die benötigten Rechte! (fly.command)");
                }
            } else {
                $sender->sendMessage(TextFormat::RED . "AzazelFly » Dieser Befehl kann nur im Spiel verwendet werden.");
            }
        }
        return true;
    }
}
