<?php

namespace royal\event;

use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;


class Seed implements Listener{
	public function onBreak(BlockBreakEvent $event){
		$block = $event->getBlock();
		$player = $event->getPlayer();

		if ($block->getId() === Block::TALL_GRASS)
		{

			$rand = mt_rand(1, 5000);
			//beterave
			if($rand == 1){
				$event->setDrops([Item::get(458, 0, 1)]);
				if($event){
					$player->sendPopup("Graine en Aetherium");
				}
			//carotte
			}elseif ($rand >= 150 && $rand <= 200){
				$event->setDrops([Item::get(391, 0, 1)]);
				if($event){
					$player->sendPopup("graine de charbon");
				}
			//patate
			}elseif ($rand <=499 && $rand >= 300){
				$event->setDrops([Item::get(392, 0, 1)]);
				$player->sendPopup("graine de Fer");
			//melon
			}elseif ($rand <=299 && $rand >= 151){
				$event->setDrops([Item::get(362, 0, 1)]);
				if ($event){
					$player->sendPopup("graine d'or");
				}
			//pumpkin
			}elseif ($rand <=500 && $rand >= 750){
				$event->setDrops([Item::get(361, 0, 1)]);
				if ($event){
					$player->sendPopup("graine de diamand ");
				}
			}elseif ($rand >= 751) {
				$player->sendPopup("la prochaine fois");
			}
		}
	}
}
# set de la graine en beterave a vérifier encore une fois
#  $config->set("xp", $config->get("xp" + 1);
#Config->save;