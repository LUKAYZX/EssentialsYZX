<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class FeedCommand extends Command {

    public function __construct() {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        parent::__construct('feed', $config->get('FEED.COMMAND.DESCRIPTION'));

    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!$sender->hasPermission('command.feed')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        $sender->getHungerManager()->setFood($sender->getHungerManager()->getMaxFood());
        $sender->sendMessage($config->get('HUNGER.SATISFIED'));

    }

}
