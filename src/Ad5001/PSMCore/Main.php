<?php 



/***
____   _____ __  __  _____               
 *     |  __ \ / ____|  \/  |/ ____|              
 *     | |__) | (___ | \  / | |     ___  _ __ ___ 
 *     |  ___/ \___ \| |\/| | |    / _ \| '__/ _ \
 *     | |     ____) | |  | | |___| (_) | | |  __/
 *     |_|    |_____/|_|  |_|\_____\___/|_|  \___|
 *                                                
 * Pocketmine Server Manager backend pocketmine plugin.
 * @author Ad5001
 * @version 1.0.0
 * @copyright (C) Ad5001 2017
 */
declare(strict_types=1);
namespace Ad5001\PSMCore;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\Command;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\generator\Generator;
use Ad5001\PSMCore\API;
class Main extends PluginBase{
	/**
	 * Checks when the plugin enables.
	 */
	public function onEnable(){
		$this->reloadConfig();
	}
	/**
	 * When the plugin loads
	 */
	public function onLoad(){
		$this->saveDefaultConfig();
	}
	/**
	 * Checks when a command executes
	 * 
	 * @param {\pocketmine\command\CommandSender} $sender
	 * @param {\pocketmine\command\Command} $cmd
	 * @param {String} $label
	 * @param {String[]} $args
	 * 
	 * @return {Boolean}
	 */
	public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{
		if(!($sender instanceof ConsoleCommandSender)) return false;
		switch($cmd->getName()){
			case "psmcoreactplugin":
			switch($args[0]) {
				case "setcfg4psm":
					switch(true){
						case $args[2] == "on" || $args[2] == "off": // Boolean
						$this->getServer()->setConfigBool($args[1], $args[2] == "on" ? true : false);
						break;
						case preg_match("/^[0-9]+$/", $args[2]): // Int
						$this->getServer()->setConfigInt($args[1], intval($args[2]));
						break;
						default: // String
						$n = $args[1];
						unset($args[1]);
						$this->getServer()->setConfigString($n, implode(" ", $args));
						break;
					}
					return true;
					break;
				case "setmotd4psm":
					$this->getServer()->getNetwork()->setName(implode(" ", $args));
					$this->getServer()->setConfigString("motd", implode(" ", $args));
					return true;
					break;
				case "setviewdistance4psm":
					$this->getServer()->setConfigInt("view-distance", intval($args[1]));
					foreach($this->getServer()->getPlayers() as $p) {
						$p->setViewDistance(intval($args[1]));
					}
					return true;
					break;
				case "createlevel4psm":
					$generator = Generator::getGenerator($args[2]);
					$this->getServer()->generateLevel($args[1], intval($args[3]), $generator);
					$this->getServer()->loadLevel($args[1]);
					return true;
					break;
				case "getplayersforpsmsolongcommandthatimsurewontbefound":
					$pls = [];
					foreach($this->getServer()->getOnlinePlayers() as $pl){
						$pls[$pl->getName()] = [
							"name" =>  $pl->getName(),
							"op" => $pl->isOp(),
							"whitelisted" => $pl->isWhitelisted(),
							"gamemode" => $pl->getGamemode()
						];
					}
					echo json_encode(["psmplayers" => $pls], JSON_PRETTY_PRINT);
					return true;
					break;
				case "getloadedlevelsforpsmthatsasuperlongcommandthatibetyoucannotenterwithoutcopypaste":
					$lvls = [];
					foreach($this->getServer()->getLevels() as $lvl){
					$lvls[$lvl->getName()] = [
						"name" => $lvl->getName() 
					];
					}
					echo json_encode(["psmlevels" => $lvls], JSON_PRETTY_PRINT);
					return true;
					break;
				case "getplugins4psmthatwillbejavascriptobjectencodedjsonbutnomanagement":
					$pls = [];
					foreach($this->getServer()->getPluginManager()->getPlugins() as $pl){
						$pls[$pl->getName()] = [
							"name" => $pl->getName(),
							"author" => $pl->getDescription()->getAuthors(),
							"description" => $pl->getDescription()->getDescription(),
							"apis" => $pl->getDescription()->getCompatibleApis(),
							"website" => $pl->getDescription()->getWebsite()
						];
					}
					echo json_encode(["psmplugins" => $pls], JSON_PRETTY_PRINT);
					return true;
					break;
				case "getlevelsgeneratorsfourpsmniceviewcheater":
					$gens = [];
					foreach(Generator::getGeneratorList() as $genName){
						$gen = Generator::getGenerator($genName);
						// safe_var_dump($gen);
						$gens[$genName] = [
							"name" => $genName
						];
					}
					echo json_encode(["psmgenerators" => $gens], JSON_PRETTY_PRINT);
					return true;
					break;
				case "getactions4psmplzdontusethiscommandiknowitshardtoresistbutdontwhatdidijustsaidokwateveryoulostafewsecondsofyourlife":
					echo json_encode(["psmActions" => [
						"playerActions" => API::$playerActions,
						"levelActions" => API::$levelActions,
						"pluginsActions" => API::$pluginsActions,
						"pluginsSpecificActions" => API::$pluginsSpecificActions
					]], JSON_PRETTY_PRINT);
					return true;
					break;
				case "getplayerinfos4psmwoohoomakeawindowlikenooneneeverdidinapocketminepluginb4":
					API::displayNotification("Dummy", "Dummy notification from PSM");
					API::displayWindow([
						"title" => "Hello world",
						"html" => "<head></head><body>Running node.js hello world!</body>"
					]);
					return true;
					break;
			}
			return true;
			break;
		}
		return false;
	} 
}
