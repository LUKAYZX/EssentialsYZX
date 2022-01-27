<?php

namespace LUKAYZX\EssentialsYZX;

use LUKAYZX\EssentialsYZX\commands\BroadcastCommand;
use LUKAYZX\EssentialsYZX\commands\DayCommand;
use LUKAYZX\EssentialsYZX\commands\FeedCommand;
use LUKAYZX\EssentialsYZX\commands\FlyCommand;
use LUKAYZX\EssentialsYZX\commands\GameModeCommand;
use LUKAYZX\EssentialsYZX\commands\HealCommand;
use LUKAYZX\EssentialsYZX\commands\MessageCommand;
use LUKAYZX\EssentialsYZX\commands\NightCommand;
use LUKAYZX\EssentialsYZX\commands\ReplyCommand;
use LUKAYZX\EssentialsYZX\commands\WarpCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;

class EssentialsYZX extends PluginBase {

    private array $replyToMessage = [];
    private array $flyingPlayers = [];

    private static EssentialsYZX $instance;

    /**
     * @return void
     */

    protected function onEnable(): void {

        self::$instance = $this;
        $this->saveResource('config.yml');
        $this->saveResource('warps.json');

        Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand('gamemode'));
        Server::getInstance()->getCommandMap()->unregister(Server::getInstance()->getCommandMap()->getCommand('tell'));

        Server::getInstance()->getCommandMap()->registerAll('EssentialsYZX',
            [
                new BroadcastCommand(),
                new GameModeCommand(),
                new MessageCommand(),
                new ReplyCommand(),
                new DayCommand(),
                new NightCommand(),
                new WarpCommand(),
                new HealCommand(),
                new FlyCommand(),
                new FeedCommand()
            ]);

    }

    /**
     * @return array
     */

    public function getReplyToMessage(): array {
        return $this->replyToMessage;
    }

    public function getFlyingPlayers(): array {
        return $this->flyingPlayers;
    }

    /**
     * @return static
     */

    public static function getInstance(): self {
        return self::$instance;
    }

}