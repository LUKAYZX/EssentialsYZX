<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\player\Player;
use JsonException;

class WarpDeleteSubCommand extends SubCommand {

    /**
     * @param Player $sender
     * @param array $args
     * @return void
     * @throws JsonException
     */

    public function execute(Player $sender, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();
        $warps = EssentialsYZX::getInstance()->getWarps();

        if (!$sender->hasPermission('command.set.warp')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('WARP.NAME.NOT.GIVEN'));
            return;
        }

        if (!$warps->exists($args[0])) {
            $sender->sendMessage($config->get('WARP.NOT.EXISTING'));
            return;
        }

        $sender->sendMessage(str_replace('{warp}', $args[0], $config->get('WARP.DELETED')));

        $warps->removeNested($args[0]);
        $warps->save();
        $warps->reload();

    }

}