<?php

namespace royal\event;

use onebone\economyapi\EconomyAPI;
use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use royal\events\XpJobAddEvent;
use royal\Main;


class graine implements Listener
{

	/**
	 * @var Main
	 */
	private $plugin;

	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public function onbreak(BlockBreakEvent $event, XpJobAddEvent $addEvent)
	{
		$main = $this->plugin;
		$player = $event->getPlayer();
		//pour get ou se trouve la config
		$config = new Config($main->getDataFolder() . "Player/" . $player->getName() . ".yml", Config::YAML);
		$block = $event->getBlock();
		$hand = $event->getPlayer()->getInventory()->getItemInHand();
		$lvlF = $config->get("lvl_Farmer");
		if ($block->getId() == Block::BEETROOT_BLOCK) {
			//      var de l'xp ici
			$config->set("xp", $config->get("xp") + 1);
			$addEvent->getXp();
			//		var de l'xp
			$config->save();
			if ($block->getId() == Block::BEETROOT_BLOCK && $hand->getId() == Item::BLAZE_ROD && $lvlF == 20) {
				$rand = mt_rand(1, 500);
				if ($event) {
					if ($rand == 2) {
						$player->getServer()->broadcastMessage("le joueur " . $player . "a gagner grâce a l'outil de farm une graine en Aetherium");
						$event->setDrops([Item::get(409, 0, 1)]);
					}
					$randMoney = mt_rand(3, 25);

					EconomyAPI::getInstance()->addMoney($player, $randMoney);
					$event->getPlayer()->sendPopup("tu as reçu" . $randMoney . "$");


				}
			}else{

				$player->sendMessage("tu n'as pas le niveau requis , continue de farmer tu l'obtiendra un jours ");
				$event->setCancelled();
			}
		}
		if ($block->getId() == Block::MELON_BLOCK){

			$config->set("xp", $config->get("xp") + 1);
			$addEvent->getXp();
			$config->save();
			$rand = mt_rand(1, 400);
			if ($block->getId() == Block::MELON_BLOCK){
				if ($rand == 2){
					$event->setDrops([Item::get(360, 0, mt_rand(1, 5))]);
				}
			}
		}

	}
}

