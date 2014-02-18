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
	private static $PluginVersion = "1.0.0";

	// Does your plugin require models? Set them here as array.
	// Example: array('model1', 'model2', 'model3')
	private static $LoadedModels = array('example');


	// -------------------------------------
	// Default Plugin Methods
	// -------------------------------------

	public function __construct()
	{
		// Do not use the constructor for any purpose. It will not work
		// Instead, use "enable", "disable" and "load" plugin functions
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
		// You can remove plugin database tables, remove plugin options
		// or perform anything related to uninstalling your plugin here
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

		// Register enable and disable hooks. Do NOT change these two lines.
		parent::RegisterEnableHook(self::$PluginCode);
		parent::RegisterDisableHook(self::$PluginCode);

		// Setup menu items
		// "set_menu_items" method will be executed inside your plugin class
		// to register menu items. Simply check "set_menu_items" method to learn
		// how you should setup your menu items on the user interface.
		parent::RegisterMenuHook(self::$PluginCode, 'set_menu_items');

		// Hook registration. To learn more about available hook listeners
		// visit the plugin development manual. Below, we registered one
		// hook as an example.
		parent::RegisterHook('Action', 'FormItem.AddTo.Admin.UserGroupLimitsForm', self::$PluginCode, 'set_user_group_form_items', 10, 1);
		parent::RegisterHook('Filter', 'UserGroup.Update.FieldValidator', self::$PluginCode, 'usergroup_update_fieldvalidator', 10, 1);
		parent::RegisterHook('Action', 'UserGroup.Update.Post', self::$PluginCode, 'usergroup_update', 10, 2);
		parent::RegisterHook('Action', 'UserGroup.Create.Post', self::$PluginCode, 'usergroup_update', 10, 2);
		parent::RegisterHook('Action', 'UserGroup.Delete.Post', self::$PluginCode, 'usergroup_delete', 10, 1);
		parent::RegisterHook('Action', 'User.Delete.Post', self::$PluginCode, 'user_delete', 10, 1000);

		// Retrieve language setting. This setting will be used to set
		// the language of the plugin. First we will try to retrieve the
		// saved language preference from "options" table. If it doesn't exist,
		// we will set the default "en" (English) language. If it exists, we will
		// set the saved one in the options table.
		$Language = Database::$Interface->GetOption(self::$PluginCode . '_Language');
		if (count($Language) == 0)
		{
			Database::$Interface->SaveOption(self::$PluginCode . '_Language', 'en');
			$Language = 'en';
		}
		else
		{
			$Language = $Language[0]['OptionValue'];
		}

		// Load the language file
		// The selected language will be loaded here. If the language file doesn't exist,
		// plugin will load the default "en" language pack.
		$ArrayPlugInLanguageStrings = array();
		if (file_exists(PLUGIN_PATH . self::$PluginCode . '/languages/' . strtolower($Language) . '/' . strtolower($Language) . '.inc.php') == true)
		{
			include_once(PLUGIN_PATH . self::$PluginCode . '/languages/' . strtolower($Language) . '/' . strtolower($Language) . '.inc.php');
		}
		else
		{
			include_once(PLUGIN_PATH . self::$PluginCode . '/languages/en/en.inc.php');
		}
		self::$ArrayLanguage = $ArrayPlugInLanguageStrings;

		unset($ArrayPlugInLanguageStrings);

		// This private method will load models
		// The following line will load models defined in self::$LoadedModules array property.
		// All database processes should be done in model files to keep your plugin code
		// structure organized. (basic MVC approach)
		self::_LoadModels();

		// Do you need to load any third party classes, helpers, libraries? Load them here.
		// There's no standards/restrictions on loading third party classes, libraries or helpers.
		// They're standard PHP functions, classes or code blocks such as Mailgun wrapper, phpmailer
		// class, etc. The most important thing is, don't forget to set the path absolute from the root
		// To help you, we have a constant: PLUGIN_PATH . self::$PluginCode . Take a look at examples
		// listed below.
		// include_once(PLUGIN_PATH . self::$PluginCode . '/libraries/111.php');
		// include_once(PLUGIN_PATH . self::$PluginCode . '/libraries/222.php');
		// include_once(PLUGIN_PATH . self::$PluginCode . '/libraries/333.php');

		// Define constants if needed. Constants to use in your classes or plugin class? You can set
		// them here, just to keep the code organized. Or you can set them anywhere in your code. Just
		// be sure that they are prefixed with the self::$PluginCode to avoid conflicts with the main
		// Oempro or other plugin constants.
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
		// On the Oempro user interface, you can insert content to specific areas. The list of
		// these specific areas can be found in our plugin development manual. This is the correct
		// method to set which menu item to show where. Below, you an find some examples.

		$ArrayMenuItems = array();
		$ArrayMenuItems[] = array(
			'MenuLocation' => 'Admin.Settings',
			'MenuID' => 'Plugin Framework',
			'MenuLink' => Core::InterfaceAppURL() . '/' . self::$PluginCode . '/admin_settings/',
			'MenuTitle' => self::$ArrayLanguage['Screen']['0001'],
		);
		$ArrayMenuItems[] = array(
			'MenuLocation' => 'Admin.TopDropMenu',
			'MenuID' => 'Plugin Framework',
			'MenuLink' => Core::InterfaceAppURL() . '/' . self::$PluginCode . '/admin_reports/',
			'MenuTitle' => self::$ArrayLanguage['Screen']['0001'],
		);
		$ArrayMenuItems[] = array(
			'MenuLocation' => 'User.TopMenu',
			'MenuID' => 'Plugin Framework',
			'MenuLink' => Core::InterfaceAppURL() . '/' . self::$PluginCode . '/email_automation/',
			'MenuTitle' => self::$ArrayLanguage['Screen']['0001'],
		);

		return array($ArrayMenuItems);
	}

	public function set_user_group_form_items($UserGroup)
	{
		// If this hook requires an authorization to admin or user areas,
		// un-comment the right line. Otherwise, this hook will be triggered
		// for admin, user or unauthorized people whenever the hook listener is
		// triggered.
		// if (self::_PluginAppHeader('Admin') == false) return;
		// if (self::_PluginAppHeader('User') == false) return;
		// if (self::_PluginAppHeader(null) == false) return;

		if (self::_PluginAppHeader('Admin') == false) return;

		$UserGroupSettings = Database::$Interface->GetOption('PluginFramework_UserGroupSettings');
		$UserGroupSettings = json_decode($UserGroupSettings[0]['OptionValue'], true);

		$ArrayViewData = array(
			'PluginLanguage' => self::$ArrayLanguage,
			'UserGroup' => $UserGroup,
			'UserGroupSettings' => (isset($UserGroupSettings[$UserGroup['UserGroupID']]) == true ? $UserGroupSettings[$UserGroup['UserGroupID']] : false)
		);
		$ArrayViewData = array_merge($ArrayViewData, InterfaceDefaultValues());

		$HTML = self::$ObjectCI->plugin_render(self::$PluginCode, 'inline_usergroup_formitems', $ArrayViewData, true, true);

		return array($HTML);
	}

	public function usergroup_update_fieldvalidator($ArrayFormRules)
	{
		$ArrayFormRules[] = array(
			'field' => 'PluginFramework[DeliveryLimit]',
			'label' => self::$ArrayLanguage['Screen']['0003'],
			'rules' => 'required|numeric',
		);
		return array($ArrayFormRules);
	}

	public function usergroup_update($UserGroup, $PostData)
	{
		if (isset($PostData['PluginFramework']['DeliveryLimit']) == true)
		{
			$UserGroupSettings = Database::$Interface->GetOption('PluginFramework_UserGroupSettings');
			$UserGroupSettings = json_decode($UserGroupSettings[0]['OptionValue'], true);

			$UserGroupSettings[$UserGroup['UserGroupID']]['DeliveryLimit'] = $PostData['PluginFramework']['DeliveryLimit'];

			Database::$Interface->SaveOption('PluginFramework_UserGroupSettings', json_encode($UserGroupSettings));
		}
	}

	public function usergroup_delete($UserGroup)
	{
		$UserGroupSettings = Database::$Interface->GetOption('PluginFramework_UserGroupSettings');
		$UserGroupSettings = json_decode($UserGroupSettings[0]['OptionValue'], true);

		if (isset($UserGroupSettings[$UserGroup['UserGroupID']]) == true)
		{
			unset($UserGroupSettings[$UserGroup['UserGroupID']]);
		}

		Database::$Interface->SaveOption('PluginFramework_UserGroupSettings', json_encode($UserGroupSettings));
	}

	public function user_delete()
	{
		$SelectedUserIDs = func_get_args();

		if (is_array($SelectedUserIDs) == true && count($SelectedUserIDs) > 0)
		{
			foreach ($SelectedUserIDs as $EachUserID)
			{
				self::$Models->messages->DeleteUserRecords($EachUserID);
			}
		}
	}


	// -------------------------------------
	// Controllers (user interface methods)
	// -------------------------------------

	// Controllers are executed through the user interface or internally. One thing that
	// you should be careful is, controller method names should be prefixed with "ui_".
	// Below, you can find an example. This controller will be called from the admin
	// settings left side menu item which is inserted inside "set_menu_items" method above.
	// Here's an example URL for the example below:
	// http://mydomain.com/oempro/app/index.php?/plugin_framework/menu_item_1/
	// In the above example URL, "plugin_framework" will tell Oempro to look inside this plugin
	// and "menu_item_1" is the name of the controller method which is prefixed with "ui_":
	//
	// Controller methods can take parameters inside in two ways. As a "GET" parameter or part
	// or the URL query string. Here's an example:
	// http://mydomain.com/oempro/app/index.php?/plugin_framework/menu_item_1/val1/val2
	//
	// We recommend you to categorize controllers for admin, user and other purposes with "admin",
	// "user" and "other" prefixes. Here's an example:
	// ui_admin_settings -> A controller which will be executed in the admin area
	// ui_user_settings -> A controller which will be executed in the user area
	// ui_run -> A controller which can be executed any where

	public function ui_menu_item_1($Val1 = '', $Val2 = '')
	{
		// The first thing that you should do inside your controller method should be checking
		// the authorization of the logged in user. If you want this controller to be accessed
		// by logged in "users" only, enable this code:
		// if (self::_PluginAppHeader('User') == false) return;

		// Or if you want this controller to be accessible by a logged in administrator, enable
		// this code:
		if (self::_PluginAppHeader('Admin') == false) return;

		// Or if you don't want any admin/user authentication check, simply enable the following
		// code:
		// if (self::_PluginAppHeader(null) == false) return;


		// You can reach CodeIgniter's all features just like the example displayed below:
		// NOTE: self::$ObjectCI is initiated in self::_PluginAppHeader method. Therefore,
		// you need to run one of these calls above first.
		self::$ObjectCI->load->helper('url');

		// These are two commonly used variables inside a method to display a success or error
		// message on the user interface. They are set here:
		$PageErrorMessage = '';
		$PageSuccessMessage = '';

		// ...
		// your code here
		// ...

		// Events
		// Let's say you have a form on the page that this controller displays to the user.
		// And you want to perform a specific process when the form is submitted. This is
		// called "event" in Oempro. You need to set event callers before loading the view.
		// In this way, you can process the requested operation, get results and if any error
		// (or success) exists, you can display a message to the user. Event methods are prefixed
		// with "_Event" to make them noticeable.
		$EventResult = self::_EventSaveSettings();
		if (is_array($EventResult) == true)
		{
			if ($EventResult[0] == false)
			{
				$PageErrorMessage = $EventResult[1];
			}
			else
			{
				$PageSuccessMessage = $EventResult[1];
			}
		}

		// Load and display the view to the user. First, we set the information which will be transferred
		// to the view file for processing:
		$ArrayViewData = array(
			// This is the page title. You should set this.
			'PageTitle' => ApplicationHeader::$ArrayLanguageStrings['PageTitle']['AdminPrefix'] . self::$ArrayLanguage['Screen']['0002'],

			// This is the plugin language file
			'PluginLanguage' => self::$ArrayLanguage,

			// Page error and success messages
			'PageErrorMessage' => $PageErrorMessage,
			'PageSuccessMessage' => $PageSuccessMessage,

			// Below, you can set unlimited amount of info to pass
			'MyValue' => 'example value'
		);
		// In order to include Oempro's default variables, don't forget to merge them below:
		$ArrayViewData = array_merge($ArrayViewData, InterfaceDefaultValues());

		// Load the view file
		self::$ObjectCI->plugin_render(self::$PluginCode, 'example_view', $ArrayViewData, true);
	}

	public function ui_admin_settings($SelectedTab = 'settings')
	{
		if (self::_PluginAppHeader('Admin') == false) return;

		Core::LoadObject('api');

		$PageErrorMessage = '';
		$PageSuccessMessage = '';

		$ExampleRecords = self::$Models->example->ExampleGetRecords();

		$ArrayViewData = array(
			'PageTitle' => ApplicationHeader::$ArrayLanguageStrings['PageTitle']['AdminPrefix'] . self::$ArrayLanguage['Screen']['0002'],
			'CurrentMenuItem' => 'Settings',
			'PluginView' => '../plugins/plugin_framework/templates/admin_settings.php',
			'SubSection' => 'Plugin Framework',
			'PluginLanguage' => self::$ArrayLanguage,
			'PageErrorMessage' => $PageErrorMessage,
			'PageSuccessMessage' => $PageSuccessMessage,
			'ExampleRecords' => $ExampleRecords
		);
		$ArrayViewData = array_merge($ArrayViewData, InterfaceDefaultValues());

		self::$ObjectCI->render('admin/settings', $ArrayViewData);
	}

	public function ui_admin_reports()
	{
		if (self::_PluginAppHeader('Admin') == false) return;

		$ArrayViewData = array(
			'PageTitle' => ApplicationHeader::$ArrayLanguageStrings['PageTitle']['AdminPrefix'] . self::$ArrayLanguage['Screen']['0005'],
			'CurrentMenuItem' => 'Drop',
			'CurrentDropMenuItem' => self::$ArrayLanguage['Screen']['0001'],
			'PluginLanguage' => self::$ArrayLanguage,
		);
		$ArrayViewData = array_merge($ArrayViewData, InterfaceDefaultValues());

		self::$ObjectCI->plugin_render(self::$PluginCode, 'admin_reports', $ArrayViewData, true);
	}



	// -------------------------------------
	// Events (events of the user interface such as save, create, delete, etc.)
	// -------------------------------------

	private function _EventSaveSettings()
	{
		return array(false, self::$ArrayLanguage['Screen']['0004']);
	}

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

		self::$AdminInformation = Admins::RetrieveAdmin(array('*'), array('CONCAT(MD5(AdminID), MD5(Username), MD5(Password))' => $_SESSION[SESSION_NAME]['AdminLogin']));

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
				if (file_exists(PLUGIN_PATH . self::$PluginCode . '/models/' . $EachModel . '.php') == false) continue;
				if (isset($InitiatedModels[$EachModel]) == true) continue;

				include_once('models/' . $EachModel . '.php');
				$ClassName = 'model_' . $EachModel;
				self::$Models->{$EachModel} = new $ClassName();
				self::$Models->{$EachModel}->Models = self::$Models;

				$InitiatedModels[$EachModel] = true;
			}
		}
	}
}