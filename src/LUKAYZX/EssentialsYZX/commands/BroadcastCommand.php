<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class BroadcastCommand extends Command {

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('broadcast', $config->get('BROADCAST.COMMAND.DESCRIPTION'), '', ['bcast', 'bc']);

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();

        if (!$sender->hasPermission('command.broadcast')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.MESSAGE.GIVEN.ERROR'));
            return;
        }

        Server::getInstance()->broadcastMessage(str_replace('{msg}', implode(' ', $args), $config->get('BROADCAST.FORMAT')));

    }
}
