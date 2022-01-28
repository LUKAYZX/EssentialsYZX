<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\commands\subcommands\GameModeAdventureSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\GameModeCreativeSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\GameModeHelpSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\GameModeSpectatorSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\GameModeSurvivalSubCommand;
use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

class GameModeCommand extends Command {

    private array $subCommands = [];

    public function __construct() {

        $config = EssentialsYZX::getInstance()->getConfig();
        parent::__construct('gamemode', $config->get('GAMEMODE.COMMAND.DESCRIPTION'), '', ['gm']);

        $this->subCommands[] = new GameModeHelpSubCommand('help');
        $this->subCommands[] = new GameModeSurvivalSubCommand('survival', ['s', '0']);
        $this->subCommands[] = new GameModeCreativeSubCommand('creative', ['c', '1']);
        $this->subCommands[] = new GameModeAdventureSubCommand('adventure', ['a', '2']);
        $this->subCommands[] = new GameModeSpectatorSubCommand('spectator', ['sp', '3']);

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $config = EssentialsYZX::getInstance()->getConfig();

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!$sender->hasPermission('pocketmine.command.gamemode')) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NO.PERMISSION.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('COMMAND.NOT.FOUND.ERROR'));
            $sender->sendMessage('§7» §cUse: /gamemode help');
            return;
        }

        foreach ($this->subCommands as $subCommand) {

            if ($subCommand->getName() === $args[0] || in_array($args[0], $subCommand->getAliases())) {
                array_shift($args);
                $subCommand->execute($sender, $args);
                return;
            }

            if (!$subCommand->getName() === $args[0] || in_array($args[0], $subCommand->getAliases())) {
                $sender->sendMessage($config->get('COMMAND.NOT.FOUND.ERROR'));
                $sender->sendMessage('§7» §cUse: /gamemode help');
            }

        }

    }

}
