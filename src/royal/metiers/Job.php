<?php


namespace royal\metiers;


use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\Config;
use royal\events\XpJobAddEvent;
use royal\Main;

class Job implements Listener
{

	/**
	 * @var Main
	 */
	private $plugin;

	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public static function getXp($player, XpJobAddEvent $addEvent){
		$event = $addEvent;
		$player = $event->getPlayer();
		$main = $event->getPlugin();
		$config = new Config($main->getDataFolder() . "Player/" . $player->getName() . ".yml", Config::YAML);
		$up = $config->get("up");
		$xp = $config->get("xp_Farmer");
		$defUp = 100;
		if ($xp == $up){
			$config->set("lvl_Farmer", $config->get("lvl_Farmer") + 1);
			$config->set("xp_Farmer", 1);
			$config->save();
			if ($config->get("lvl_Farmer") == 100){
				$config->set("up", $defUp);
				$config->save();
			}else{
				$player->sendMessage("tu vient de augmenter ton niveau de farmer au niveau ". $config->get("lvl_Farmer"));
				$f = $up * 10 / 100;
				$final = $up + $f;
				$config->set("up", $final);
				$config->save();
			}
		}
	}
}