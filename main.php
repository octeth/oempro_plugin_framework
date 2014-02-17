<?php

include_once(PLUGIN_PATH . 'plugin_framework/libraries/licensing.php');

class plugin_framework extends Plugins
{
	// -------------------------------------
	// Plugin must-have variablies:
	// -------------------------------------
	// - Do not rename them!
	// - Do not remove them!

	// The value of this property should be the same as your class name
	private static $PluginCode = 'plugin_framework';

	// Just leave this as an empty array. It will be populated later on
	private static $ArrayLanguage = array();

	// Leave this variable as null. It will store the CodeIgniter framework
	public static $ObjectCI = null;

	// Leave it empty. If the authorization level is "user", this array
	// will contain the user information
	private static $UserInformation = array();

	// Lave it empty. If the authorization level is "admin", this array
	// will contain the admin information
	private static $AdminInformation = array();

	// Leave this variable as it is. Do not change it.
	private static $Models = null;

	// These variables will be used in the near future, do not change or
	// remove them.
	private static $PluginLicenseKey = null;
	private static $PluginLicenseStatus = true;
	private static $PluginLicenseInfo = null;

	// This is the version of the plugin. It should be in x.x.x format.
	// Example: 1.0.5
	private static $PluginVersion = "1.0.1";

	// Does your plugin require models? Set them here as array.
	// Example: array('model1', 'model2', 'model3')
	private static $LoadedModels = array();


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
		// This private method will load models
		self::_LoadModels();

		// License check
		// TODO: License check engine will be implemented soon. This engine
		// 		 call will let you to sell your plugins on Octeth Plugin Store
		//		 and avoid piracy

		// If your plugin depends on new database tables, you should setup
		// these tables and data here.
		self::$Models->db_setup->SetupDatabaseSchema();
	}

	// This method is executed when the administrator clicks "Disable" link
	// next to this plugin in Plugin management of the Oempro admin area
	public function disable_plugin_framework()
	{
	}

	// This method is executed whenever an Oempro page (admin, user or any other pages)
	// is executed. The plugin must be enabled to get this method executed. It's somewhat
	// like the constructor method.
	// Menu item placements, hook registration and all on-load processes should be done
	// in this method.
	public function load_plugin_framework()
	{
		// License check
		// TODO: License check engine will be implemented soon. This engine
		// 		 call will let you to sell your plugins on Octeth Plugin Store
		//		 and avoid piracy

		// Register enable and disable hooks
		parent::RegisterEnableHook(self::$PluginCode);
		parent::RegisterDisableHook(self::$PluginCode);

		// Setup menu items
		parent::RegisterMenuHook(self::$PluginCode, 'set_menu_items');

		// Hook registration. To learn more about available hook listeners
		// visit the plugin development manual
		parent::RegisterHook('Action', 'FormItem.AddTo.Admin.UserGroupLimitsForm', self::$PluginCode, 'hook_call_1', 10, 1);
		parent::RegisterHook('Filter', 'UserGroup.Update.FieldValidator', self::$PluginCode, 'hook_call_2', 10, 1);

		// Retrieve language setting. This setting will be used to set
		// the language of the plugin
		$Language = Database::$Interface->GetOption(self::$PluginCode.'_Language');
		if (count($Language) == 0)
		{
			Database::$Interface->SaveOption(self::$PluginCode.'_Language', 'en');
			$Language = 'en';
		}
		else
		{
			$Language = $Language[0]['OptionValue'];
		}

		// Load the language file
		$ArrayPlugInLanguageStrings = array();
		if (file_exists(PLUGIN_PATH . self::$PluginCode.'/languages/' . strtolower($Language) . '/' . strtolower($Language) . '.inc.php') == true)
		{
			include_once(PLUGIN_PATH . self::$PluginCode.'/languages/' . strtolower($Language) . '/' . strtolower($Language) . '.inc.php');
		}
		else
		{
			include_once(PLUGIN_PATH . self::$PluginCode.'/languages/en/en.inc.php');
		}
		self::$ArrayLanguage = $ArrayPlugInLanguageStrings;

		unset($ArrayPlugInLanguageStrings);

		// This private method will load models
		self::_LoadModels();

		// Do you need to load any third party classes, helpers, libraries? Load them here:
		// include_once('abc.php');
		// include_once('222.php');
		// include_once('333.php');

		// Define constants if needed
		// define(strtoupper(self::$PluginCode).'_SESSION_THRESHOLD', 5);
	}


	// -------------------------------------
	// Hooks, menu item setups, template tag setups
	// -------------------------------------

	// This method setups menu items on the user interface
	// For more info about available menu item locations,
	// please refer to our plugin development manual
	public function set_menu_items()
	{
		$ArrayMenuItems = array();
		$ArrayMenuItems[] = array(
			'MenuLocation' => 'Admin.Settings',
			'MenuID' => 'Menu Item #1',
			'MenuLink' => Core::InterfaceAppURL() . '/'.self::$PluginCode.'/menu_item_1/',
			'MenuTitle' => self::$ArrayLanguage['Screen']['0001'],
		);
		$ArrayMenuItems[] = array(
			'MenuLocation' => 'Admin.TopDropMenu',
			'MenuID' => 'Menu Item #2',
			'MenuLink' => Core::InterfaceAppURL() . '/'.self::$PluginCode.'/menu_item_2/',
			'MenuTitle' => self::$ArrayLanguage['Screen']['0001'],
		);
		$ArrayMenuItems[] = array(
			'MenuLocation' => 'User.TopMenu',
			'MenuID' => 'Menu Item #3',
			'MenuLink' => Core::InterfaceAppURL() . '/'.self::$PluginCode.'/menu_item_3/',
			'MenuTitle' => self::$ArrayLanguage['Screen']['0001'],
		);

		return array($ArrayMenuItems);
	}

	public function hook_call_1()
	{
		// If this hook requires an authorization to admin or user areas,
		// un-comment the right line. Otherwise, this hook will be triggered
		// for admin, user or unauthorized people whenever the hook listener is
		// triggered.
		// if (self::_PluginAppHeader('Admin') == false) return;
		// if (self::_PluginAppHeader('User') == false) return;

		// ...
		// your code here
		// check plugin development manual for more information about hooks
		// ...

		return;
	}

	public function hook_call_2()
	{
		// If this hook requires an authorization to admin or user areas,
		// un-comment the right line. Otherwise, this hook will be triggered
		// for admin, user or unauthorized people whenever the hook listener is
		// triggered.
		// if (self::_PluginAppHeader('Admin') == false) return;
		// if (self::_PluginAppHeader('User') == false) return;

		// ...
		// your code here
		// check plugin development manual for more information about hooks
		// ...

		return;
	}


	// -------------------------------------
	// Controllers (user interface methods)
	// -------------------------------------


	// -------------------------------------
	// Events (events of the user interface such as save, create, delete, etc.)
	// -------------------------------------


	// -------------------------------------
	// Private methods
	// -------------------------------------

	// This method should be called in every user interface method (controller) as the
	// first line. You can force controller to be executed for "Admin" or "User" authorized
	// account owners.
	private function _PluginAppHeader($Section = 'Admin')
	{
		self::$ObjectCI =& get_instance();

		// License status check
		// TODO: License status check will be processed here in the future

		if (Plugins::IsPlugInEnabled(self::$PluginCode) == false)
		{
			$Message = ApplicationHeader::$ArrayLanguageStrings['Screen']['1707'];
			self::$ObjectCI->display_public_message('', $Message);
			return false;
		}

		if ($Section == 'Admin')
		{
			self::_CheckAdminAuth();
		}
		elseif ($Section == 'User')
		{
			self::_CheckUserAuth();
		}

		return true;
	}

	// This is a private method for checking logged in user administrator privileges
	private function _CheckAdminAuth()
	{
		Core::LoadObject('admin_auth');
		Core::LoadObject('admins');

		AdminAuth::IsLoggedIn(false, InterfaceAppURL(true) . '/admin/');

		self::$AdminInformation = Admins::RetrieveAdmin(array('*'), array('CONCAT(MD5(AdminID), MD5(Username), MD5(Password))'=>$_SESSION[SESSION_NAME]['AdminLogin']));

		return;
	}

	// This is a private method for checking logged in user privileges
	private function _CheckUserAuth()
	{
		Core::LoadObject('user_auth');

		UserAuth::IsLoggedIn(false, InterfaceAppURL(true) . '/user/');

		self::$UserInformation = Users::RetrieveUser(array('*'), array('CONCAT(MD5(UserID), MD5(Username), Password)' => $_SESSION[SESSION_NAME]['UserLogin']), true);

		if (Users::IsAccountExpired(self::$UserInformation) == true)
		{
			$_SESSION['PageMessageCache'] = array('Error', ApplicationHeader::$ArrayLanguageStrings['Screen']['1617']);
			self::$ObjectCI->load->helper('url');
			redirect(InterfaceAppURL(true) . '/user/logout/', 'location', '302');
		}

		return;
	}

	// Models defined in self::$LoadedModels will be loaded here.
	private function _LoadModels()
	{
		include_once('models/base.php');
		self::$Models = new stdClass();

		self::$LoadedModels = array_merge(array('db_setup'), self::$LoadedModels);

		$InitiatedModels = array();

		if (count(self::$LoadedModels) > 0)
		{
			foreach (self::$LoadedModels as $EachModel)
			{
				if (file_exists(PLUGIN_PATH.self::$PluginCode.'/models/'.$EachModel.'.php') == false) continue;
				if (isset($InitiatedModels[$EachModel]) == true) continue;

				include_once('models/'.$EachModel.'.php');
				$ClassName = 'model_'.$EachModel;
				self::$Models->{$EachModel} = new $ClassName();
				self::$Models->{$EachModel}->Models = self::$Models;

				$InitiatedModels[$EachModel] = true;
			}
		}
	}
}