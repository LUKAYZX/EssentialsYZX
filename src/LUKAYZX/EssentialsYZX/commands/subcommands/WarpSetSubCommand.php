<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use JsonException;

class WarpSetSubCommand extends SubCommand {

    /**
     * @param Player $sender
     * @param array $args
     * @return void
     * @throws JsonException
     */

    public function execute(Player $sender, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        $warps = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'warps.json', Config::JSON);

        if (!$sender->hasPermission('command.set.warp')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('WARP.NAME.NOT.GIVEN'));
            return;
        }

        if ($args[0] === 'set' || $args[0] === 'delete' || $args[0] === 'list' || $args[0] === 'del') {
            $sender->sendMessage($config->get('WARP.NAME.ILLEGAL'));
            return;
        }

        $sender->sendMessage(str_replace('{warp}', $args[0], $config->get('WARP.CREATED')));

        $warps->setNested($args[0] . '.X', $sender->getPosition()->getFloorX());
        $warps->setNested($args[0] . '.Y', $sender->getPosition()->getFloorY());
        $warps->setNested($args[0] . '.Z', $sender->getPosition()->getFloorZ());
        $warps->setNested($args[0] . '.World', $sender->getWorld()->getFolderName());

        $warps->save();
        $warps->reload();

    }

}
