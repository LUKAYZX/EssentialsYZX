<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class ReplyCommand extends Command {

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('reply', $config->get('REPLY.COMMAND.DESCRIPTION'), '', ['r']);

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();
        $replyToMessage = EssentialsYZX::getInstance()->getReplyToMessage();

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.MESSAGE.GIVEN.ERROR'));
            return;
        }

        if (!array_key_exists($sender->getName(), $replyToMessage)) {
            $sender->sendMessage($config->get('NO.MESSAGE.FOR.REPLY'));
            return;
        }

        $lastMessageSenderName = $replyToMessage[$sender->getName()];
        $lastMessageSender = Server::getInstance()->getPlayerExact($lastMessageSenderName);

        if (!$lastMessageSender instanceof Player) {
            $sender->sendMessage($config->get('PLAYER.FOR.REPLY.NOT.ONLINE'));
            return;
        }

        $lastMessageSender->sendMessage(str_replace(['{sender}', '{receiver}', '{msg}'], [$sender->getName(), $lastMessageSenderName, implode(' ', $args)], $config->get('MSG.FORMAT.RECEIVER')));
        $sender->sendMessage(str_replace(['{sender}', '{receiver}', '{msg}'], [$sender->getName(), $lastMessageSenderName, implode(' ', $args)], $config->get('MSG.FORMAT.SENDER')));

    }

}
