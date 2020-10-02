<?php


namespace royal\commandes;



use jojoe77777\FormAPI\SimpleForm;
use onebone\economyapi\EconomyAPI;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use royal\Main;


class jobui extends PluginCommand
{

	/**
	 * @var Main
	 */
	private $plugin;

	public function __construct(string $name, Main $owner)
    {
        parent::__construct($name, $owner);
        $this->setDescription("les jobs ?");
        $this->setUsage("/job");
        $this->setAliases(["jb"]);
        $this->plugin = $owner;
    }

    /**
     * @param CommandSender $player
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed|void
     */
    public function execute(CommandSender $player, string $commandLabel, array $args) : bool{
		if (!$player instanceof Player){
			$player->sendMessage(TextFormat::GOLD . "tu ne peux pas utiliser le /jobui de la console ou sinon tu va crash");
			return true;
		}
        if ($player instanceof Player) {
            $this->job($player);
            return true;
        }
    }
    public function job($player)
    {
        Server::getInstance()->getPluginManager()->getPlugin("FormAPI");
        Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");

        $form = new  SimpleForm(function (Player $player, int $data = null){
            $result = $data;
            $main = $this->plugin;
            $joueur = $player->getPlayer();
			$name = $player->getName();

            $config = new Config($main->getDataFolder() . "Player/" . $joueur->getName() . ".yml", Config::YAML);
            if($result === null){
                return true;
            }
            $meta = 0;
            switch($result) {
                case 0:
                    if ($config->get("lvl_Farmer") == 5){
                        $player->getServer()->broadcastMessage("tu as bien récuperer 10 graines de charbons  ");
                        $player->getInventory()->addItem(([Item::get(Item::CARROT,  $meta, 1)]));
                        break;
                    }else{
                    	$player->sendMessage("tu n'as pas le niveau requis");
					}
                case 1:
                    if ($config->get("lvl_Farmer") == 10){
                        $player->getPlayer()->sendMessage("tu a récupéré 32 de graine de fer " . $name ." ");
                        $player->getPlayer()->sendMessage("tu débloque la possibilitée de casser les graines de fer ");
                        $player->getInventory()->addItem(([Item::get(392, $meta, 32)]));
                        break;
                    }
				case 2:
					if ($config->get("lvl_Farmer") == 15){
						$player->getPlayer()->sendMessage("tu à récupérer 10k de money ");
						$player->sendMessage("tu débloque la possibilitée de casser les graines en or");
						EconomyAPI::getInstance()->addMoney($player, 10000);
						break;
					}
				case 3:
					if ($config->get("lvl_Farmer") == 20){
						$player->getPlayer()->sendMessage("tu as récupérer 10 graines de diamant ");
						$player->getPlayer()->sendMessage("tu débloque la possibilitée de casser les graines de diamant ");
						$player->getInventory()->addItem([Item::get(Item::PUMPKIN_SEEDS, $meta, 10)]);
					}
					break;
			}
            return true;
        });
        $form->setTitle("Farmer récompence ");
        $form->setContent("récupères les récompenses de farmer");
        $form->addButton("[5] 10 graines de charbons ");
        $form->addButton("[10] 32 graines de fer ");
        $form->addButton("[15] 10 de money");
        $form->addButton("[20] 10 graines de diamant");
        $form->sendToPlayer($player);
    }
}