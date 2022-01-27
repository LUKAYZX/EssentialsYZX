<?php

namespace LUKAYZX\EssentialsYZX\commands;

use LUKAYZX\EssentialsYZX\commands\subcommands\WarpDeleteSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\WarpHelpSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\WarpListSubCommand;
use LUKAYZX\EssentialsYZX\commands\subcommands\WarpSetSubCommand;
use LUKAYZX\EssentialsYZX\EssentialsYZX;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\world\Position;

class WarpCommand extends Command {

    private array $subCommands = [];

    public function __construct() {

        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);
        parent::__construct('warp', $config->get('WARP.COMMAND.DESCRIPTION'));

        $this->subCommands[] = new WarpHelpSubCommand('help');
        $this->subCommands[] = new WarpListSubCommand('list');
        $this->subCommands[] = new WarpSetSubCommand('set');
        $this->subCommands[] = new WarpDeleteSubCommand('delete', ['del']);

    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */

    public function execute(CommandSender $sender, string $commandLabel, array $args) {


        $config = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'config.yml', Config::YAML);

        if (!$sender instanceof Player) {
            $sender->sendMessage($config->get('COMMAND.EXECUTION.NOT.INGAME.ERROR'));
            return;
        }

        if (!isset($args[0])) {
            $sender->sendMessage($config->get('COMMAND.NOT.FOUND.ERROR'));
            $sender->sendMessage('§7» §cUse: /warp help');
            return;
        }

        foreach ($this->subCommands as $subCommand) {

            if ($subCommand->getName() === $args[0] || in_array($args[0], $subCommand->getAliases())) {

                array_shift($args);
                $subCommand->execute($sender, $args);

            } else {

                $warps = new Config(EssentialsYZX::getInstance()->getDataFolder() . 'warps.json', Config::JSON);

                if (!$warps->exists($args[0])) {
                    $sender->sendMessage($config->get('WARP.NOT.EXISTING'));
                    return;
                }

                $sender->sendMessage(str_replace('{warp}', $args[0], $config->get('WARPED.SUCCESSFULLY')));
                $sender->teleport(new Position($warps->getNested($args[0] . '.X'), $warps->getNested($args[0] . '.Y'), $warps->getNested($args[0] . '.Z'), Server::getInstance()->getWorldManager()->getWorldByName($warps->getNested($args[0] . '.World'))));

            }

        }

    }

}