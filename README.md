# PSMCore plugin
This pocketmine plugin is used to make interaction between the Pocketmine Server Manager app and the server in a lot larger interaction than commands.    
For example, this plugin is used to provide the lists of players, worlds, and plugins to the app.    
    
## API
This plugin also include a basic API allowing you to use and GUIs to your pocketmine plugins.    
Every method in the API is located under the class Ad5001\PSMCore\API.    
    
1. Player, levels, and plugins actions.
	When the owner of the server interacts with the GUIs in the server players/levels/plugins list, a bunch of action is shown such as "OP", "Add to whitelist", "Kick", ... Plugins can add their own actions in the form of a command. Each action is refeared under a name which will be shown to the server owner.    
	
	In a player action, you can use %p to use the player name and %s to prompt the server owner for some values (place of the value in the command shown).    
	In a level action you can use %l for the level name and %s to prompt the server owner for a value (place of the value in the command shown).    
	In a plugins action you can use %p for the plugin name and %s to prompt the server owner for a value (place of the value in the command shown).    
	You can also define some actions for some specific plugins such as configuration commands, ...
	Examples:    
	- Add a player action with the name 'Example':
	```php
	\Ad5001\PSMCore\API::addPlayerAction('Example', "kill %p");
	```
	- Remove a level action named 'Example':
	```php
	\Ad5001\PSMCore\API::removeLevelAction('Example');
	```
	- Add a plugin specific action for plugin Example which runs command 'example' with a selected prompt.
	```php
	\Ad5001\PSMCore\API::addPluginSpecificAction(Server::getInstance()->getPluginManager()->getPlugin("Example"), "Ask for example", "example %s");
	```
	
2. Displaying a notification
Wanna send a notice to the server owner? Sending a notifications can remind him of doing some stuffs, provide a better support and more.    
Displaying a notification is pretty easy. It uses the OS notifications system.    
Displaying a notification requires 3 things: a title, a message, and, optionaly, buttons and a command callback.   
You can use %b in a command to get button's name.    
Example:    
```php
\Ad5001\PSMCore\API::displayNotification("Title", "Message", ["OK", "Cancel"], "cmd callback");
```

3. Creating a window.
If you need a larger space to display large informations, you can use a window.    
Use a window to:    
- [x] display some informations requested by the user    
- [x] add an online service login    
- [x] create forms that the user needs to complete (like config editing)    
*DON'T* use a window to:     
- [ ] have a constant information window (mobile OSes dont like that).    
- [ ] display some basic informations. Use notifications for that.    
- [ ] have multiple windows at the same time.
To integrate perfectly with the app UI, you should look at our [design guide](https://github.com/pmt-mcpe-fun/PSMCorePlugin/blob/master/DESIGN.md).    
Windows are HTML rendered with a nodejs integration. You can look at the [electron] api to get more infos and explore the src code of PSM to add some more integrations with the app.    
Only one argument is required to create a window which is an array of options.    
Possible options:
	 - title: Title of the window when no webpage title is specified (optional, string)
	 - file: path to an HTML file to render or, (1 of the 3 must be choosen, string)
	 - weburl: url to render or, (1 of the 3 must be choosen, string)
	 - html: HTML code to render. (1 of the 3 must be choosen, string)
	 - width: Window width (optional, int)
	 - height: Window height (optional, int)
Example:
```php
\Ad5001\PSMCore\API::displayWindow(["weburl" => "https://psm.mcpe.fun", "title" => "PSM's website"]);
```

4. TODOs: Custom tabs

## Tell PSM about your plugin
If you want to use the PSM GUI API into your plugin, you might want the users to know it. For that, it's simple as adding this key to your plugin.yml:
```yaml
psmimplements: true
```
but if you also want to notice the user that your plugin doesn't have any API, just change the true to false in this key:
```yaml
psmimplements: false
```
