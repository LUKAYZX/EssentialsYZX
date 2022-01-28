<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\world\World;

class DayCommand extends Command {

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('day', $config->get('DAY.COMMAND.DESCRIPTION'));

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

        if (!$sender->hasPermission('pocketmine.command.time.set')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        $sender->sendMessage(str_replace('{time}', '1000', $config->get('SUCCESSFULLY.CHANGED.TIME')));
        $sender->getWorld()->setTime(World::TIME_DAY);

    }

}