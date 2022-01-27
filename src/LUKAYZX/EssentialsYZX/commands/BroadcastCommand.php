<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\utils\Config;

class BroadcastCommand extends Command {

    public function __construct() {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        parent::__construct('broadcast', $config->get('BROADCAST.COMMAND.DESCRIPTION'), '', ['bcast', 'bc']);

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);

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
