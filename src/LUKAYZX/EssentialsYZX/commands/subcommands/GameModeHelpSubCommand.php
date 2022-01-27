<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class GameModeHelpSubCommand extends SubCommand {

    public function execute(Player $sender, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);

        foreach ($config->get('GAMEMODE.HELP') as $message) {
            $sender->sendMessage($message);
        }

    }

}
