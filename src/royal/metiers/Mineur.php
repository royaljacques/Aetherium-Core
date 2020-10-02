<?php

namespace royal\metiers;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use royal\events\XpJobAddEvent;
use royal\Main;

class Mineur implements Listener
{
	/**
	 * @var Main
	 */
	private $plugin;

	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public function jobBreak(BlockBreakEvent $event, XpJobAddEvent $addEvent){
		$main = $this->plugin;
		$player = $event->getPlayer();
		//pour get ou se trouve la config
		$config = new Config($main->getDataFolder() . "Player/" . $player->getName() . ".yml", Config::YAML);

		//Variables
		$block = $event->getBlock()->getId();
		$name = $player->getName();
		if ($block == 15){
			$up = $config->get("xp_Mineur");
			$up1 = $up + 1;
			$config->set("xp_Mineur", $up1);
			$event->getPlayer()->sendMessage("coucou ");
			var_dump($config);
			$config->save();

		}elseif ($block == 56){
			$config->set("xp_Mineur", $config->get("xp_Mineur") + 3);
			var_dump($config);
			$config->save();

		}elseif ($block == 16){
			$config->set("xp_Mineur", $config->get("xp_Mineur") + 1);
			var_dump($config);
			$config->save();
		}elseif ($block == 14){
			$config->set("xp_Mineur", $config->get("xp_Mineur") + 2);
			var_dump($config);
			$config->save();
		}elseif ($block == 73){
			$config->set("xp_Mineur", $config->get("xp_Mineur") + 1);
			var_dump($config);
			$config->save();
		}

	}

}