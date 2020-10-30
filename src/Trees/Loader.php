<?php

namespace Trees;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use GrowEvent\event\StructureGrowEvent;
use MyPlot\MyPlot;
use pocketmine\level\Position;

class Loader extends PluginBase implements Listener {

    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onGrow(StructureGrowEvent $event) {
        if($event->getPlayer() != null && $event->getPlayer()->hasPermission("myplot.admin.trees"))
            return;
        $myPlot = MyPlot::getInstance();
        $block = $event->getBlock();
        $level = $block->getLevelNonNull();
        $plotFrom = $myPlot->getPlotByPosition(Position::fromObject($block, $level));
        foreach($event->getBlocks() as $evBlock) {
            $plotBlock = $myPlot->getPlotByPosition(Position::fromObject($evBlock, $level));
            if($plotFrom !== $plotBlock) {
                $event->setCancelled(true);
                break;
            }
        }
    }

}