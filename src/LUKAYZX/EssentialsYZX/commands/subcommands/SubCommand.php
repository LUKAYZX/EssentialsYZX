<?php

namespace LUKAYZX\EssentialsYZX\commands\subcommands;

use pocketmine\player\Player;

abstract class SubCommand {

    private array $aliases;
    private string $name;

    public function __construct(string $name, array $aliases = []) {

        $this->name = $name;
        $this->aliases = $aliases;

    }

    /**
     * @param Player $sender
     * @param array $args
     */

    abstract function execute(Player $sender, array $args);

    /**
     * @return string
     */

    public function getName(): string {
        return $this->name;
    }

    /**
     * @return array
     */

    public function getAliases(): array {
        return $this->aliases;
    }

}
