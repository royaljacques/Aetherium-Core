<?php

namespace Royal\Task;

use pocketmine\scheduler\Task;
use royal\Main;

class CooldownTask extends Task
{
	private $plugin;

	public function __construct(Main $plugin)
	{
		$this->plugin = $plugin;
	}

	public function onRun($tick)
	{
		$this->plugin->Timer();
	}
}
