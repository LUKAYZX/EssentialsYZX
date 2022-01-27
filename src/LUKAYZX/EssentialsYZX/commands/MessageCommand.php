<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;

class MessageCommand extends Command {

    public function __construct() {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        parent::__construct('msg', $config->get('MSG.COMMAND.DESCRIPTION'));

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        $replyToMessage = EssentialsYZX::getInstance()->getReplyToMessage();

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PLAYER.GIVEN.ERROR'));
            return;
        }

        if (!isset($args[1])) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.MESSAGE.GIVEN.ERROR'));
            return;
        }

        if ($args[0] === $sender->getName()) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.CANNOT.SEND.MESSAGE.YOURSELF.ERROR'));
            return;
        }

        if (Server::getInstance()->getPlayerByPrefix($args[0]) === null || !Server::getInstance()->getPlayerByPrefix($args[0]) instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.PLAYER.NOT.FOUND.ERROR'));
            return;
        }

        $receiver = Server::getInstance()->getPlayerByPrefix(array_shift($args));

        if (array_key_exists($receiver->getName(), $replyToMessage)) {

            if ($replyToMessage[$receiver->getName()] === $sender->getName()) {
                return;
            }

            unset($replyToMessage[$receiver->getName()]);

        }

        $replyToMessage[$receiver->getName()] = $sender->getName();

        $receiver->sendMessage(str_replace(['{sender}', '{receiver}', '{msg}'], [$sender->getName(), $receiver->getName(), implode(' ', $args)], $config->get('MSG.FORMAT.RECEIVER')));
        $sender->sendMessage(str_replace(['{sender}', '{receiver}', '{msg}'], [$sender->getName(), $receiver->getName(), implode(' ', $args)], $config->get('MSG.FORMAT.SENDER')));

    }

}