<?php

declare(strict_types=1);

namespace pathfinder\algorithm\cost;

use pocketmine\block\Block;

abstract class CostCalculator {
    public function __construct(){
        $this->registerBlocks();
    }

    public function registerBlocks(): void {}

    protected function register(Block $block, int $cost, bool $allStates = true): void {
        if($allStates) {
            for($meta = 0; $meta <= 15; $meta++) {
                $fullId = ($block->getTypeId() << Block::INTERNAL_STATE_DATA_BITS) | $meta;
                self::$BLOCK_COSTS[$fullId] = $cost;
            }
            return;
        }
        self::$BLOCK_COSTS[$block->getStateId()] = $cost;
    }

    protected static array $BLOCK_COSTS = [];

    public static function getCost(Block $block): int {
        return self::$BLOCK_COSTS[$block->getStateId()] ?? 1;
    }
}