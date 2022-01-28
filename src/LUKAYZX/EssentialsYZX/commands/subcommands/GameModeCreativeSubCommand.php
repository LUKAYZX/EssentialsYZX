<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\GameMode;
use pocketmine\player\Player;

class GameModeCreativeSubCommand extends SubCommand {

    /**
     * @param Player $sender
     * @param array $args
     * @return void
     */

    public function execute(Player $sender, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();

        $sender->sendMessage(str_replace('{gamemode}', '1', $config->get('SUCCESSFULLY.CHANGED.GAMEMODE')));
        $sender->setGamemode(GameMode::CREATIVE());

    }

}
