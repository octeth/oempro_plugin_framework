<?php

include_once(PLUGIN_PATH . 'plugin_framework/libraries/licensing.php');

class plugin_framework extends Plugins
{
	// -------------------------------------
	// Plugin must-have variablies:
	// -------------------------------------
	// - Do not rename them!
	// - Do not remove them!
	private static $ArrayLanguage = array();
	public static $ObjectCI = null;
	private static $UserInformation = array();
	private static $AdminInformation = array();
	private static $Models = null;
	private static $PluginLicenseKey = null;
	private static $PluginLicenseStatus = true;
	private static $PluginVersion = "1.0.1";
	private static $PluginLicenseInfo = null;


	// -------------------------------------
	// Default Plugin Methods
	// -------------------------------------

	public function __construct()
	{
		// Do not use the constructor for any process. It will not work
		// Instead, use enable, disable and load plugin functions
	}

	// This method is executed when the administrator clicks "Enable" link
	// next to this plugin in Plugin manager of the Oempro admin area
	public function enable_plugin_framework()
	{
	}

	// This method is executed when the administrator clicks "Disable" link
	// next to this plugin in Plugin management of the Oempro admin area
	public function disable_plugin_framework()
	{
	}

	// This method is executed whenever an Oempro page (admin, user or any other pages)
	// is executed. The plugin must be enabled to get this method executed. It's somewhat
	// like the constructor method.
	public function load_plugin_framework()
	{
	}


	// -------------------------------------
	// Hooks, menu item setups, template tag setups
	// -------------------------------------


	// -------------------------------------
	// Controllers
	// -------------------------------------


	// -------------------------------------
	// Events
	// -------------------------------------


	// -------------------------------------
	// Private methods
	// -------------------------------------


}