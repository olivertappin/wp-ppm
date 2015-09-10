<?php
/**
 * Oliver Tappin (http://www.olivertappin.com)
 *
 * @link      http://www.olivertappin.com
 * @copyright Copyright (c) 2015 Oliver Tappin (http://www.olivertappin.com)
 * @license   http://www.olivertappin.com/license License
 */

require dirname(__DIR__) . '/../../../../wp-load.php';

use Core\Cli;
use Core\Environment;
use Core\Wordpress\Wordpress;

// install: Go through each plugin and install them (if they don't exist)
// update: Go through and update them and update the json file
// init: Regenerate the current plugins.json file using the files in the plugins directory

$installed = 0;
$file = __DIR__ . '/../../plugins.json';
$pluginsDirectory = realpath(__DIR__ . '/../../../../plugins');

if (!file_exists($file)) {
    Cli::uiError('The plugins.json file does not exist. To create one, run `php plugins.php init`');
    exit;
}

$data = file_get_contents($file);
$data = json_decode($data);

if ($data === null) {
    Cli::uiError('There seems to be an error with your plugins.json file');
    exit;
}

foreach ($data->plugins as $plugin => $version) {
    Cli::uiMessage('Installing plugin: ' . $plugin);

    $source = 'https://downloads.wordpress.org/plugin/' . $plugin . '.' . $version . '.zip';
    $target = $pluginsDirectory . '/' . $plugin . '.zip';

    $rh = fopen($source, 'rb');
    $wh = fopen($target, 'w+b');

    if (!$rh || !$wh) {
        Cli::uiError('Failed to install plugin: ' . $plugin);
        continue;
    }

    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === false) {
            Cli::uiError('Failed to install plugin: ' . $plugin);
            continue 2;
        }
        flush();
    }

    fclose($rh);
    fclose($wh);

    exec('cd ' . $pluginsDirectory . ' && unzip -o ' . $target);
    unlink($target);

    $installed++;
}

if ($installed > 0) {
    Cli::uiMessage('----------');
    Cli::uiMessage($installed . ' plugins installed successfully');
}
