<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class FlyCommand extends Command {

    public function __construct() {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        parent::__construct('fly', $config->get('FLY.COMMAND.DESCRIPTION'));

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        $flyingPlayers = EssentialsYZX::getInstance()->getFlyingPlayers();

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!$sender->hasPermission('command.fly')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        if (!isset($flyingPlayers[$sender->getName()])) {
            $flyingPlayers[$sender->getName()] = true;
            $sender->setAllowFlight(true);
            $sender->setFlying(true);
            $sender->sendMessage($config->get('FLY.ENABLED'));
        } else {
            unset($flyingPlayers[$sender->getName()]);
            $sender->setAllowFlight(false);
            $sender->setFlying(false);
            $sender->sendMessage($config->get('FLY.DISABLED'));
        }

    }

}
