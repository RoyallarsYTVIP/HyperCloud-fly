<?php

namespace FlySystem\Aleondev;

use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\CommandExecutor;
use pocketmine\event\player\PlayerMoveEvent;

class Main extends PluginBase implements Listener {

    public $players = array();

     public function onEnable() {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getLogger()->info("FlySystem Aktiv");
     }

     public function onDisable() {
        $this->getLogger()->info("FlySystem Disable");
     }
   
    public function onCommand(CommandSender $sender, Command $cmd, $label,array $args) : bool {
        if(strtolower($cmd->getName()) == "fly") {
            if($sender instanceof Player) {
                if($this->isPlayer($sender)) {
                    $this->removePlayer($sender);
                    $sender->setAllowFlight(false);
                    $sender->sendMessage("§7[§eFlySystem§7]§b>>" . $this->getConfig()->get("Fly.False"));
                    return true;
                }
                else{
                    $this->addPlayer($sender);
                    $sender->setAllowFlight(true);
                    $sender->sendMessage("§7[§eFlySystem§7]§b >>" . $this->getConfig()->get("Fly.True"));
                    return true;
                }
            }
            else{
                $sender->sendMessage("§7[§eFlySystem§7]§b>>" . $this->getConfig()->get("Fly.True"));
                return true;
            }
        }
    }
    public function addPlayer(Player $player) {
        $this->players[$player->getName()] = $player->getName();
    }
    public function isPlayer(Player $player) {
        return in_array($player->getName(), $this->players);
    }
    public function removePlayer(Player $player) {
        unset($this->players[$player->getName()]);
    }
}
