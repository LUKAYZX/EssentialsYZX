<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class FlyCommand extends Command {

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('fly', $config->get('FLY.COMMAND.DESCRIPTION'));

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();
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
