<?php

namespace Azazel\Fly;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Main extends PluginBase implements Listener{

    public function onJoin(PlayerJoinEvent $event) : void{
        $player = $event->getPlayer();
        if(!$player->isCreative()){
            $player->setAllowFlight(false);
            $player->setFlying(false);
            $player->sendMessage("§bServer §8»§7 Dein Flugmodus wurde deaktiviert.");
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
        if($command->getName() === "fly"){
            if(!$sender instanceof Player){
                $sender->sendMessage("Diesen Befehl kannst du nur im Spiel benutzen.");
                return false;
            }
            if($sender->hasPermission("fly.command")){
                if(!$sender->isCreative()){
                    if(!$sender->getAllowFlight()){
                        $sender->setAllowFlight(true);
                        $sender->setFlying(true);
                        $sender->sendMessage("§bServer §8» §7Dein Flugmodus wurde aktiviert.");
                    }else{
                        $sender->setAllowFlight(false);
                        $sender->setFlying(false);
                        $sender->sendMessage("§bServer §8»§c Dein Flugmodus wurde deaktiviert.");
                    }
                }else{
                    $sender->sendMessage("§bServer §8»§c Dieser Befehl funktioniert nur im Überlebensmodus.");
                    return false;
                }
            }else{
                $sender->sendMessage("§bServer §8»§c Du darst diesen Befehl nicht benutzen.");
                return false;
            }
        }
        return true;
    }
}