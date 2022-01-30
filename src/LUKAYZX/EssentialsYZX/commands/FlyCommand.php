<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;

class FlyCommand extends Command {

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('fly', $config->get('FLY.COMMAND.DESCRIPTION'));

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!$sender->hasPermission('command.fly')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        if (isset($args[0]) && $sender->hasPermission('command.fly.other') && Server::getInstance()->getPlayerExact($args[0]) instanceof Player) {

            $target = Server::getInstance()->getPlayerExact($args[0]);

            if (!$target->getAllowFlight()) {

                $target->setAllowFlight(true);
                $target->setFlying(true);
                $target->sendMessage(str_replace('{name}', $sender->getName(), $config->get('FLY.ENABLED.BY.OTHER')));

                $sender->sendMessage(str_replace('{name}', $target->getName(), $config->get('FLY.ENABLED.FOR.OTHER')));

            } else {

                $target->setAllowFlight(false);
                $target->setFlying(false);
                $target->sendMessage(str_replace('{name}', $sender->getName(), $config->get('FLY.DISABLED.BY.OTHER')));

                $sender->sendMessage(str_replace('{name}', $target->getName(), $config->get('FLY.DISABLED.FOR.OTHER')));

            }
            return;
        }

        if (!$sender->getAllowFlight()) {

            $sender->setAllowFlight(true);
            $sender->setFlying(true);
            $sender->sendMessage($config->get('FLY.ENABLED'));

        } else {

            $sender->setAllowFlight(false);
            $sender->setFlying(false);
            $sender->sendMessage($config->get('FLY.DISABLED'));

        }

    }

}
