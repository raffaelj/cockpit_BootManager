<?php
/**
 * Boot Manater for Cockpit CMS
 * 
 * @see       https://github.com/raffaelj/cockpit_BootManager
 * @see       https://github.com/agentejo/cockpit/
 * 
 * @version   0.1.1
 * @author    Raffael Jesche
 * @license   MIT
 */

$bootManager = $app->retrieve('bootmanager', null);

if (!$bootManager) return;

$bootOrder = [];

if (COCKPIT_ADMIN && COCKPIT_API_REQUEST && isset($bootManager['api'])) {
    $bootOrder = $bootManager['api'];
}

if (COCKPIT_ADMIN && !COCKPIT_API_REQUEST && isset($bootManager['ui'])) {
    $bootOrder = $bootManager['ui'];
}

if (!COCKPIT_ADMIN && !COCKPIT_API_REQUEST && isset($bootManager['lib'])) {
    $bootOrder = $bootManager['lib'];
}

if (COCKPIT_CLI && isset($bootManager['cli'])) {
    $bootOrder = $bootManager['cli'];
}

if (empty($bootOrder) && isset($bootManager['global'])) {
    $bootOrder = $bootManager['global'];
}

if (empty($bootOrder)) {
    return;
}

$moduleDirs = [
    'core'   => COCKPIT_DIR.'/modules',
    'addons' => COCKPIT_DIR.'/addons',
];

if ($customAddonDirs = $app->retrieve('loadmodules', null)) {
    $i = 1;
    foreach ($customAddonDirs as $dir) {
        $moduleDirs['custom'.$i++] = $dir;
    }
}

$modules = [];

// get names and real paths
foreach ($moduleDirs as $type => $dir) {

    foreach (new \DirectoryIterator($dir) as $module) {

        if ($module->isFile() || $module->isDot()) continue;
        if ($module->getBasename() == 'Cockpit') continue; // will always load first

        $modules[$module->getBasename()] = [
            'path' => $module->getRealPath(),
            'type' => $type,
        ];

    }

}

// register modules
foreach($bootOrder as $module) {

    $app->registerModule($module, $modules[$module]['path']);

}
