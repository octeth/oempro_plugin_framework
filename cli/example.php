#!/usr/bin/php
<?php
/*
 * This is an example CLI module which can be used to build your performance sensitive
 * modules such as send engines, queue processors, etc. Running PHP from CLI will eliminate
 * the risk of web browser based issues such as web browser time-outs, etc.
 *
 * To run this CLI module, simply run the following command in CLI:
 * $ php /path/to/oempro/plugins/plugin_framework/cli/example.php
 *
 * to get the list of available options:
 * $ php /path/to/oempro/plugins/plugin_framework/cli/example.php -h
 *
 */

// Set the value of this variable to the plugin code, which is the directory name of your plugin
$PluginCode = 'plugin_framework';

// Do not let this module to be executed from a web browser
if (isset($_SERVER['REMOTE_ADDR']) == true) die('This script can not be executed from the web browser. It should be executed in CLI mode.');

// Setup some initial "required" parameters. Do not change these. Keep them unchanged.
$DS = DIRECTORY_SEPARATOR;
$APP_PATH = rtrim(str_replace($DS . 'plugins/'.$PluginCode.'/cli' . $DS, '', dirname(__FILE__) . $DS), $DS) . $DS;
$DATA_PATH = $APP_PATH . 'data' . $DS;

// Include Oempro's config file
$IsCLI = true;
include_once $DATA_PATH . 'config.inc.php';

// If not ran from CLI, display error and exit. Final check for web access
if (Core::RunningFromCLI() == false)
{
	Core::DisplayCLIBrowserError('EMAIL_PIPE');
	exit;
}

// Load initial required modules. This library is used to output in CLI
Core::LoadObject('octethcli');
$ObjectCLI = new Octeth_CLI();

// Load the Oempro language
$ArrayLanguageStrings = Core::LoadLanguage(LANGUAGE, '', TEMPLATE_PATH . 'languages');

// Verbose level. 0 -> disabled, 1, 2. This variable can be used to display verbose log entries during the process. Optional.
$VerboseLevel = 0;

// CLI options processing. For more information on this, please refer to:
// http://tr1.php.net/getopt
$CLI_Options = getopt('hu:v:');

// Display the help for this CLI module
if (isset($CLI_Options['h']) == true)
{
	$ObjectCLI->writeln('');
	$ObjectCLI->writeln($ObjectCLI->green('---------------------------------------------'));
	$ObjectCLI->writeln($ObjectCLI->yellow('Plugin Framework and Boilerplate For Oempro'));
	$ObjectCLI->writeln($ObjectCLI->yellow('(c)Copyright 1999-' . date('Y') . ' Octeth. All rights reserved.'));
	$ObjectCLI->writeln('');
	$ObjectCLI->writeln($ObjectCLI->blue('Usage:'));
	$ObjectCLI->writeln($ObjectCLI->blue('php ' . APP_PATH . '/plugins/'.$PluginCode.'/cli/example.php'));
	$ObjectCLI->writeln($ObjectCLI->blue('Options:'));
	$ObjectCLI->writeln($ObjectCLI->blue("-h\t\tDisplay this help"));
	$ObjectCLI->writeln($ObjectCLI->blue("-v <value>\tVerbose level. Default 0, disabled. Available: 0, 1, 2"));
	$ObjectCLI->writeln('');
	$ObjectCLI->writeln($ObjectCLI->yellow('For more information:'));
	$ObjectCLI->writeln($ObjectCLI->yellow('http://octeth.com/help/plugin-development/'));
	$ObjectCLI->writeln($ObjectCLI->green('---------------------------------------------'));
	$ObjectCLI->writeln('');
	$ObjectCLI->writeln('');
	exit;
}

// Set the verbose level. (If you'd like to use)
if (isset($CLI_Options['v']) == true && $CLI_Options['v'] != '')
{
	$AvailableVerboseLevels = array(0, 1, 2);
	if (in_array($CLI_Options['v'], $AvailableVerboseLevels) == true)
	{
		$VerboseLevel = $CLI_Options['v'];
	}
}

// Environment settings. Change, add or remove settings based on your needs
set_time_limit(0);
ignore_user_abort(true);
@ini_set('memory_limit', '512M');
@ini_set('max_execution_time', '0');

// Log the process as started. This is a standard procedure for CLI modules. It registers your process to Oempro's
// "process" table
$ProcessCode = $PluginCode.'_example';
$ProcessLogID = Core::RegisterToProcessLog($ProcessCode);

// Variables. The following variables are standard variables and it will be good to keep them. Use them to output
// success and error messages.
$ErrorExists = false;
$ErrorMessage = '';
$SuccessMessage = '';

/*
 * Okay, now it's your turn. Let the show begin, make your magic and build your CLI module.
 */

// ...
// your code here
// ...

// Here's an example output: success or failure
$SuccessMessage = 'Example process completed';
// or
$ErrorExists = true;
$ErrorMessage = 'Example process failed';


// Register the process as "completed". This should be called at the end, when the process is completed.
Core::RegisterToProcessLog($ProcessCode, 'Completed', $ShellMessage, $ProcessLogID);

// Output and exit
if ($ErrorExists == true)
{
	$ObjectCLI->writeln('');
	$ObjectCLI->writeln($ObjectCLI->red($ErrorMessage));
	$ObjectCLI->writeln('');
}
else
{

	$ObjectCLI->writeln('');
	$ObjectCLI->writeln($ObjectCLI->green($SuccessMessage));
	$ObjectCLI->writeln('');
}

exit;
