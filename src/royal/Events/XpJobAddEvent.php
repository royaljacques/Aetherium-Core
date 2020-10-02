<?php


namespace royal\events;


use pocketmine\event\Event;
use pocketmine\Player;
use pocketmine\plugin\Plugin;

class XpJobAddEvent extends Event
{

	private $player;
	private $job;
	private $xp;
	private $plugin;

	public function __construct(Player $player , Plugin $plugin, $job, $xp) {
		$this->player = $player;
	}

	/**
	 * @return mixed
	 */
	public function getPlayer()
	{
		return $this->player;
	}

	/**
	 * @return mixed
	 */
	public function getJob()
	{
		return $this->job;
	}

	/**
	 * @return mixed
	 */
	public function getXp()
	{
		return $this->xp;
	}

	public function getPlugin(): Plugin
	{
		return $this->plugin;
	}

}