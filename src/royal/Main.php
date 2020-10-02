<?php
declare(strict_types=1);

namespace royal;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\inventory\FurnaceRecipe;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\CraftingDataPacket;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use royal\commandes\{feed, jobui};
use royal\event\{graine, Hammer, Seed};
use royal\metiers\{Mineur};
use royal\events\XpJobAddEvent;
use royal\PiocheUI\pioche;
use Royal\Task\CooldownTask;


/**
 * Class Main
 * @package royal
 */
class Main extends PluginBase implements Listener
{

	private $cooldown;

	public function onEnable()
	{
		@mkdir($this->getDataFolder());
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getCommandMap()->register("feed", new feed("feed", $this));
		$this->getLogger()->notice("/feed activer");
		$this->getServer()->getPluginManager()->registerEvents(new Seed(), $this);
		$this->getServer()->getCommandMap()->register("pioche", new pioche("pioche", $this));
		$this->getLogger()->notice("/pioche activer ");
		$this->getServer()->getCommandMap()->register("jobui", new jobui("jobui", $this));
		$this->getLogger()->notice("/jobui activer  ");
		$this->getServer()->getPluginManager()->registerEvents(new graine($this), $this);
		$this->getLogger()->notice("event graine load ");
		$this->getServer()->getPluginManager()->registerEvents(new Seed(), $this);
		$this->getLogger()->notice("event Seed load ");
		$this->getServer()->getPluginManager()->registerEvents(new Mineur($this), $this);
		$this->getScheduler()->scheduleRepeatingTask(new CooldownTask($this), 25);
		$this->DataFurnace();
		$this->cooldown = new Config($this->getDataFolder() . "Cooldown.yml", Config::YAML);

		$this->getLogger()->notice("Plugin quest a faire , plugin hammer qui duplique a faire ");
	}

	/**
	 * @param PlayerJoinEvent $event
	 */
	public function onJoin(PlayerJoinEvent $event)
	{
		$joueur = $event->getPlayer();
		$name = $joueur->getName();


		$this->getServer()->broadcastPopup("§a+" . $name . " +");
		if (!$joueur->hasPlayedBefore()) {
			$player = $event->getPlayer();
			$config = new Config($this->getDataFolder() . "player/" . $player->getName() . ".yml", Config::YAML);
			$config->set("xp_Farmer", 1);
			$config->set("lvl_Farmer", 1);
			$config->set("xp_Mineur", 1);
			$config->set("lvl_Mineur", 1);
			$config->set("up", 100);
			$config->save();
		} else {
			$joueur->sendMessage("tu es troll");
		}
	}

	/**
	 * @param PlayerQuitEvent $event
	 */
	public function onQuit(PlayerQuitEvent $event)
	{
		$joueur = $event->getPlayer();
		$name = $joueur->getName();


		$this->getServer()->broadcastPopup("§4-" . $name . "-");
	}

	public function timer()
	{
		foreach ($this->cooldown->getAll() as $player => $time) {
			$time--;
			$this->cooldown->set($player, $time);
			$this->cooldown->save();
			if ($time == 0) {
				$this->cooldown->remove($player);
				$this->cooldown->save();
			}
		}
	}
	public function AddXp(XpJobAddEvent $event){
		$player = $event->getPlayer();
		$config = $this->getConfig()->get("Xp");

	}
}