<?php

declare(strict_types=1);

namespace pathfinder;

use pathfinder\command\PathfinderCommand;
use pathfinder\entity\PlayerEntity;
use pocketmine\entity\EntityDataHelper;
use pocketmine\entity\EntityFactory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\world\World;

class Pathfinder extends PluginBase {
    public static Pathfinder $instance;

    protected function onEnable(): void{
        self::$instance = $this;

        Server::getInstance()->getCommandMap()->register("pathfinder", new PathfinderCommand());

        EntityFactory::getInstance()->register(PlayerEntity::class, function(World $world, CompoundTag $nbt) : PlayerEntity{
            return new PlayerEntity(EntityDataHelper::parseLocation($nbt, $world), $nbt);
        }, ["PlayerEntity"]);
    }
}