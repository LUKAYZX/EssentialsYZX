<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\Player;

class GameModeHelpSubCommand extends SubCommand {

    public function execute(Player $sender, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();

        foreach ($config->get('GAMEMODE.HELP') as $message) {
            $sender->sendMessage($message);
        }

    }

}
