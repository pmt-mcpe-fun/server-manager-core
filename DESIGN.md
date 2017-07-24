# PSM Window design guide.
Using a PSM window might be hard. Here is a list of things that would make your window better integrating the app UI and be cross platform:    
1. Using the material design    
	The entire PSM app's UI was built using [google's material design](https://material.io/web). If you use this framework to create your window, it may be better integriert to the whole UI.   
	The main app theme colors are:    
	 - primary: #4CAF50
    - accent: #B0FF59
    - background: #fff
	You can copy [these lines](https://github.com/pmt-mcpe-fun/ServerManager/blob/master/assets/css/psm.css#L22-L34) to get the full list of css styles applied to the app.
2. A close button    
	Not all OSes allows a window closing using the "close" button (like Android). Adding a "close" button like at the bottom of your page may help a lot the user and improve his experience.    
	If you use the webview of a website (like login, or dev website) you could use the "webview" tag to provide a view of the website and having a close button.    
3. Using only one window.    
	You could use the app internal API to interact with your plugin in the window so you wouldn't have to have multiple windows. Using a lot of windows may cause lag and decreses a lot the user experience. Consider using only one window that is not permanent.