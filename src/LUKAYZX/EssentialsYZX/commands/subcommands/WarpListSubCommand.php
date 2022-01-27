<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\Player;
use pocketmine\utils\Config;

class WarpListSubCommand extends SubCommand {

    public function execute(Player $sender, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        $warps = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'warps.json', Config::JSON);

        $sender->sendMessage(str_replace('{warps}', implode('§7, §a', $warps->getAll(true)), $config->get('WARP.LIST.FORMAT')));

    }

}