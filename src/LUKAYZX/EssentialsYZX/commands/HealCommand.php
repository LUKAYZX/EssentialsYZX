<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class HealCommand extends Command {

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('heal', $config->get('HEAL.COMMAND.DESCRIPTION'));

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!$sender->hasPermission('command.heal')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        $sender->setHealth($sender->getMaxHealth());
        $sender->sendMessage($config->get('SUCCESSFULLY.HEALED'));

    }
}
