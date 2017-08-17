<?php 
/***
 *      _____   _____ __  __  _____               
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
use pocketmine\plugin\Plugin;

class API {
	
	/** @var {String[]} */
	static $playerActions = [
		"OP" => "op %p",
		"DeOP" => "deop %p",
		"Add to whitelist" => "whitelist add %p",
		"Remove from whitelist" => "whitelist remove %p",
		"Kick" => "kick %p",
		"Ban" => "ban %p",
		"Ban-Ip" => "ban-ip %p"
	];
	/** @var {String[]} */
	static $levelActions = [];
	/** @var {String[]} */
	static $pluginsActions = [];
	/** @var {String[]} */
	static $pluginsSpecificActions = [];
	
	/**
	 * Adds a command to execute when the name of the action is clicked on the app for a player.
	 * Use %p to symbolise the player in the command.
	 * Use %a to ask the user for a something in the command.
	 * Commands can only be launched in the console so it's recommended to check if the sender is a ConsoleCommandSender
	 * The name will be displayed as action on the app.
	 * 
	 * @param {String} $name
	 * @param {String} $cmd
	 * 
	 * @return {Void}
	 */
	public static function addPlayerAction(string $name, string $cmd) {
		self::$playerActions[$name] = $cmd;
	}
	
	/**
	 * Removes an already added command to the players actions.
	 * 
	 * @param {String} name
	 * 
	 * @return {Void}
	 */
	public static function removePlayerAction(string $name) {
		unset(self::$playerActions[$name]);
	}
	
	/**
	 * Adds a command to execute when the name of the action is clicked on the app for a level.
	 * Use %l to symbolise the level name in the command.
	 * Use %a to ask the user for a something in the command.
	 * Commands can only be launched in the console so it's recommended to check if the sender is a ConsoleCommandSender
	 * The name will be displayed as action on the app.
	 * 
	 * @param {String} $name
	 * @param {String} $cmd
	 * 
	 * @return {Void}
	 */
	public static function addLevelAction(string $name, string $cmd) {
		self::$levelActions[$name] = $cmd;
	}
	
	/**
	 * Removes an already added command to the levels actions.
	 * 
	 * @param {String} name
	 * 
	 * @return {Void}
	 */
	public static function removeLevelAction(string $name) {
		unset(self::$levelActions[$name]);
	}
	
	/**
	 * Adds a command to execute when the name of the action is clicked on the app for a plugin.
	 * Use %p to symbolise the plugin name in the command.
	 * Use %a to ask the user for a something in the command.
	 * Commands can only be launched in the console so it's recommended to check if the sender is a ConsoleCommandSender
	 * The name will be displayed as action on the app.
	 * 
	 * @param {String} $name
	 * @param {String} $cmd
	 * 
	 * @return {Void}
	 */
	public static function addPluginAction(string $name, string $cmd) {
		self::$pluginsActions[$name] = $cmd;
	}
	
	/**
	 * Removes an already added command to the plugins actions.
	 * 
	 * @param {String} name
	 * 
	 * @return {Void}
	 */
	public static function removePluginAction(string $name) {
		unset(self::$pluginsActions[$name]);
	}
	
	/**
	 * Adds a command to execute when the name of the action is clicked on the app for a specific plugin.
	 * Use %p to symbolise the plugin name in the command.
	 * Use %a to ask the user for a something in the command.
	 * Commands can only be launched in the console so it's recommended to check if the sender is a ConsoleCommandSender
	 * The name will be displayed as action on the app.
	 * 
	 * @param {\pocketmine\plugin\Plugin} $plugin
	 * @param {String} $name
	 * @param {String} $cmd
	 * 
	 * @return {Void}
	 */
	public static function addPluginSpecificAction(Plugin $plugin, string $name, string $cmd) {
		self::$pluginsSpecificActions[$plugin->getName()][$name] = $cmd;
	}
	
	/**
	 * Removes an already added command to the players actions.
	 * 
	 * @param {\pocketmine\plugin\Plugin} $plugin
	 * @param {String} name
	 * 
	 * @return {Void}
	 */
	public static function removePluginSpecificAction(Plugin $plugin, string $name) {
		unset(self::$pluginsSpecificActions[$plugin->getName()][$name]);
	}
	
	/**
	 * Display a notification for the server OS. 
	 * Should normally work even if the window is closed.
	 * Use $cmdCb as a command callback when the notification is clicked. Use %b for button clicked name.
	 * 
	 * @param {String} $title
	 * @param {String} $msg 
	 * @param {String[]} $buttons 
	 * @param {String} $cmdCb
	 * 
	 * @return {Void}
	 */
	public static function displayNotification(string $title, string $msg, array $buttons = ["OK"], string $cmdCb = "nothing"){
		echo json_encode(["psmnotification" => [
			"title" => $title,
			"message" => $msg,
			"actions" => $buttons,
			"callback" => $cmdCb
		]], JSON_PRETTY_PRINT); // Sends a message to the app to display a notification.
	}
	
	/**
	 * Displays a window. DO NOT SPAM THIS FUNCTION!
	 * Use this function only if necessary (like google log in, long information displaying, ect...).
	 * You should use displayNotification instead.
	 * The window will be launched in NodeJS mode so you'll be able to use all the NodeJS api.
	 * Possible options:
	 * 	- title: Title of the window when no webpage title is specified (optional, string)
	 * 	- file: path to an HTML file to render or, (1 of the 3 must be choosen, string)
	 * 	- weburl: url to render or, (1 of the 3 must be choosen, string)
	 * 	- html: HTML code to render. (1 of the 3 must be choosen, string)
	 * 	- width: Window width (optional, int)
	 * 	- height: Window height (optional, int)
	 * 
	 */
	public static function displayWindow(array $options) {
		echo json_encode(["psmwindow" => $options], JSON_PRETTY_PRINT);
	}
}