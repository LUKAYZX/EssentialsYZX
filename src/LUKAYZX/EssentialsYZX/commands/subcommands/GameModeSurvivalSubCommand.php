<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class GameModeSurvivalSubCommand extends SubCommand {

    /**
     * @param Player $sender
     * @param array $args
     * @return void
     */

    public function execute(Player $sender, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);

        $sender->sendMessage(str_replace('{gamemode}', '0', $config->get('SUCCESSFULLY.CHANGED.GAMEMODE')));
        $sender->setGamemode(GameMode::SURVIVAL());

    }

}