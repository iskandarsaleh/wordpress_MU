=== Skinner ===
Contributors: tompahoward
Donate link: http://windyroad.org/software/wordpress/skinner-plugin/#donate
Tags: theme, skin, admin, Windy Road
Requires at least: 2.0
Tested up to: 2.2
Stable tag: 0.0.4

The Skinner plugin adds skin selection and editing to WordPress for Skinner compatible themes.

== Description ==

The Skinner plugin adds skin selection and editing to [WordPress](http://wordpress.org) for [Skinner compatible themes](http://windyroad.org/software/wordpress/skinner-plugin/#skinner-themes).  The Skinner plugin is based on the Theme Selector and Theme Editor that are built into [WordPress](http://wordpress.org), giving them the the same level of functionality, look and feel.

== Installation ==

1. copy the 'skinner' directory to your wp-contents/plugins directory.
1. Activate Skinner in your plugins administration page.
1. Install and activate a [Skinner compatible theme](http://windyroad.org/software/wordpress/skinner-plugin/#skinner-themes).
1. You will now see the 'Skins' and 'Skin Editor' entries in the 'Presentation' menu.
1. You will also see a 'Skin Switcher' widget in the 'Widgets' menu.

== Frequently Asked Questions ==

== Screenshots ==

1. Picking a skin
2. Editing a skin

== Creating Skinable Themes ==
The only requirement for a Theme to be skinable is that there must be a default skin.  To create a default skin create a 'skins/default/style.css' or 'skins/default/style.css.php' file within your theme directory (themes.wordpress.net doesn't like multiple style.css files in a theme, so if you wish to host it there, make sure you use 'skins/default/style.css.php' for you default skin).  You should create a section at the top of the file like the following, so Skinner can know a little about the default skin:
* For 'style.css' files, use:
	/*  
	Skin Name: Default
	Skin URI: URL of the theme
	Description: Some description
	Version:
	Author: Your name
	Author URI: Your URL
	*/
* For 'style.css.php' files use:
	<?php
	/*  
	Skin Name: Default
	Skin URI: URL of the theme
	Description: Some description
	Version:
	Author: Your name
	Author URI: Your URL
	*/
	header('Content-type: text/css'); ?>

Additionally, you can add a 'Skins URI' entry to the header of the **theme's** style sheet ('style.css') with the URL of the skins archive for the theme.  This will allow Skinner to point users of the theme to that URL, so they can get more skins.

That's it!  The theme is now skinable, you just need to create some skins.

== Creating Skins ==
To create a skin for a theme:

1. first make sure the theme is skinable or make it skinable yourself.
1. Pick a name for your skin
1. Create a directory with that name in the theme's 'skins' directory.
1. Create a 'style.css' or 'style.css.php' file within your skin directory.  You should create a section at the top of the file like the following, so Skinner can know a little about your skin:
* For 'style.css' files, use:
	/*  
	Skin Name: Your Skin Name
	Skin URI: URL of your skin
	Description: Some description
	Version: Some Version
	Author: Your name
	Author URI: Your URL
	*/
* For 'style.css.php' files use:
	<?php
	/*  
	Skin Name: Your Skin Name
	Skin URI: URL of your skin
	Description: Some description
	Version: Some Version
	Author: Your name
	Author URI: Your URL
	*/
	header('Content-type: text/css'); ?>
1. Add your skin specific styling to the file you just created.
1. Place any files specific to your skin within your skin directory.
1. Optionally, you can create a 'functions.php' file within your skin directory.  It will be included automatically when your skin is active.
1. Optionally, you can create a 'screenshot.png', 'screenshot.gif', 'screenshot.jpg' or 'screenshot.jpeg' file within your skin directory; it should be 300px wide and 240px high.  It will be used on the Skin selector page.
1. If the theme has a skin archive, go to it and let them know that you have created a new skin for the theme.

= Release Notes =
* 0.0.5
	* Skinner is now compatible with the [Theme Switcher plugin](http://wordpress.org/extend/plugins/theme-switcher/ ).
	* You can now allow your readers to switch skins.  Code based on [Ryan Boren's](http://boren.nu/ ) [Theme Switcher plugin](http://wordpress.org/extend/plugins/theme-switcher/ ).
* 0.0.4
	* Added support for old WordPress 2.0 installations
* 0.0.3
	* Added [BeNice](http://wordpress.org/extend/plugins/be-nice/ ) support.
	* Removed nonce generation and referrer checking as it was not working. Will re-introduce later.
* 0.0.2
	* Fixed some validation issues.
	* Fixed order of style sheet includes.
* 0.0.1
	* Fixed output of the footer in the skin selector
	* The 'Get More Skins' title is no longer displayed if a skins archive is not specified
* 0.0.0
	* Initial release