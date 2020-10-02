<?php

declare(strict_types=1);

namespace royal\PiocheUI;

use onebone\economyapi\EconomyAPI;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use royal\Form\FormAPI\SimpleForm;
use Royal\Main;

/**
 * Class pioche
 * @package royal\PiocheUI
 */
class pioche extends PluginCommand{
	public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->setDescription("ouvre la pioche");
        $this->setUsage("/pioche");
        $this->setAliases(["fui"]);
        $this->Plugin = $owner;
    }
    public function execute(CommandSender $player, string $commandLabel, array $args): bool
    {
		if (!$player instanceof Player){
			$player->sendMessage(TextFormat::GOLD . "tu ne peux pas utiliser le /pioche de la console ou sinon tu va crash");
			return true;
		} else {
			$this->openPiocheForm($player);
			return true;
		}



    }

	/**
	 * @param $player
	 * @return SimpleForm
	 */
	public function openPiocheForm($player){
         Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
		$form = new SimpleForm(function (Player $player, int $data = null){
			$result = $data;
			if($result === null){
				return true;
			}
			switch($result){
				case 0:
					$myMoney = EconomyAPI::getInstance()->myMoney($player);

					$player->sendMessage("Vous avez : " . $myMoney . " en monnaie.");
					break;

				case 1:

					$myMoney = EconomyAPI::getInstance()->myMoney($player);

					if($myMoney < 25) {
						$player->sendMessage("tu n'as pas assez ");
						break;
					}elseif($myMoney > 25) {
						$player->getInventory()->addItem(Item::get(369, 0,1));
						EconomyAPI::getInstance()->reduceMoney($player, 25);
						break;
					}
			}
			return true;
		});
		$form->setTitle("PiocheSpawner");
		$form->setContent("Acheter une pioche Spéciale spawner?");
		$form->addButton("que me reste t'il ");
		$form->addButton("Acheter la pioche ");
		$form->sendToPlayer($player);
		return $form;
		}
}
