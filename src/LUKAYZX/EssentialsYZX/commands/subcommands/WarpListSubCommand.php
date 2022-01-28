<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\Player;

class WarpListSubCommand extends SubCommand {

    public function execute(Player $sender, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();
        $warps = EssentialsYZX::getInstance()->getWarps();

        $sender->sendMessage(str_replace('{warps}', implode('§7, §a', $warps->getAll(true)), $config->get('WARP.LIST.FORMAT')));

    }

}