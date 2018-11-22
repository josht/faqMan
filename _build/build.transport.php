<?php
/**
 * faqMan
 *
 * Copyright 2010 by Josh Tambunga <josh+faqman@joshsmind.com>
 *
 * faqMan is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * faqMan is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * faqMan; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package faqman
 */
/**
 * faqMan build script
 *
 * @package faqman
 * @subpackage build
 */
$mtime  = microtime();
$mtime  = explode(' ', $mtime);
$mtime  = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

// Define package
define('PKG_NAME','faqMan');
define('PKG_NAME_LOWER',strtolower(PKG_NAME));
define('PKG_VERSION','1.3.0');
define('PKG_RELEASE','pl');

// Define sources
$root    = dirname(dirname(__FILE__)) . '/';
$sources = array(
    'root'          => $root,
    'build'         => $root . '_build/',
    'data'          => $root . '_build/data/',
    'resolvers'     => $root . '_build/resolvers/',
    'chunks'        => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/',
    'snippets'      => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/snippets/',
    'plugins'       => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/plugins/',
    'lexicon'       => $root . 'core/components/' . PKG_NAME_LOWER . '/lexicon/',
    'docs'          => $root . 'core/components/' . PKG_NAME_LOWER . '/docs/',
    'pages'         => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/pages/',
    'source_assets' => $root . 'assets/components/' . PKG_NAME_LOWER,
    'source_core'   => $root . 'core/components/' . PKG_NAME_LOWER,
);
unset($root);

/* override with your own defines here (see build.config.sample.php) */
require_once $sources['build'] . '/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once $sources['build'] . '/includes/functions.php';

$modx = new modX();
$modx->initialize('mgr');

// Used for nice formatting of log messages
echo '<pre>';
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, '{core_path}components/' . PKG_NAME_LOWER . '/');
$modx->log(modX::LOG_LEVEL_INFO, 'Created Transport Package and Namespace.');

// Create category
$category = $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);

// Add snippets
$snippets = include $sources['data'] . 'transport.snippets.php';
if (!is_array($snippets)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in snippets.');
} else {
    $category->addMany($snippets);
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($snippets) . ' snippets.');
}

/* create category vehicle */
$attr = array(
    xPDOTransport::UNIQUE_KEY                => 'category',
    xPDOTransport::PRESERVE_KEYS             => false,
    xPDOTransport::UPDATE_OBJECT             => true,
    xPDOTransport::RELATED_OBJECTS           => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Children' => array(
            xPDOTransport::PRESERVE_KEYS             => false,
            xPDOTransport::UPDATE_OBJECT             => true,
            xPDOTransport::UNIQUE_KEY                => 'category',
            xPDOTransport::RELATED_OBJECTS           => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
                'Snippets' => array(
                    xPDOTransport::PRESERVE_KEYS => false,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY    => 'name',
                ),
                'Chunks' => array(
                    xPDOTransport::PRESERVE_KEYS => false,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY    => 'name',
                ),
            ),
        ),
        'Snippets' => array(
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY    => 'name',
        ),
        'Chunks' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY    => 'name',
        ),
    ),
);
$vehicle = $builder->createVehicle($category, $attr);

$modx->log(modX::LOG_LEVEL_INFO, 'Adding file resolvers to category...');
$vehicle->resolve('file', array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file', array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$builder->putVehicle($vehicle);

/* load system settings */
$settings = include $sources['data'] . 'transport.settings.php';
if (!is_array($settings)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in settings.');
} else {
    $attributes = array(
        xPDOTransport::UNIQUE_KEY    => 'key',
        xPDOTransport::PRESERVE_KEYS => true,
        xPDOTransport::UPDATE_OBJECT => false,
    );
    foreach ($settings as $setting) {
        $vehicle = $builder->createVehicle($setting, $attributes);
        $builder->putVehicle($vehicle);
    }
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($settings) . ' System Settings.');
}
unset($settings, $setting, $attributes);

// Load menu
$menu = include $sources['data'] . 'transport.menu.php';
if (empty($menu)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in menu.');
} else {
    $vehicle= $builder->createVehicle($menu, array (
        xPDOTransport::PRESERVE_KEYS             => true,
        xPDOTransport::UPDATE_OBJECT             => true,
        xPDOTransport::UNIQUE_KEY                => 'text',
        xPDOTransport::RELATED_OBJECTS           => true,
        xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
            'Action' => array (
                xPDOTransport::PRESERVE_KEYS => false,
                xPDOTransport::UPDATE_OBJECT => true,
                xPDOTransport::UNIQUE_KEY    => array ('namespace','controller'),
            ),
        ),
    ));
    $modx->log(modX::LOG_LEVEL_INFO, 'Adding in PHP resolvers...');
    $vehicle->resolve('php', array(
        'source' => $sources['resolvers'] . 'resolve.tables.php',
    ));
    $vehicle->resolve('php', array(
            'source' => $sources['resolvers'] . 'resolve.dbchanges.php',
    ));
    $vehicle->resolve('php', array(
        'source' => $sources['resolvers'] . 'resolve.settings.php',
    ));
    $vehicle->resolve('php', array(
        'source' => $sources['resolvers'] . 'resolve.paths.php',
    ));
    $builder->putVehicle($vehicle);
    $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in menu.');
}
unset($vehicle, $menu);

// Now pack in the license file, readme and setup options
$builder->setPackageAttributes(array(
    'license'   => file_get_contents($sources['docs'] . 'license.txt'),
    'readme'    => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    //'setup-options' => array(
        //'source' => $sources['build'].'setup.options.php',
    //),
));
$modx->log(modX::LOG_LEVEL_INFO, 'Added package attributes and setup options.');

// Zip up package
$modx->log(modX::LOG_LEVEL_INFO, 'Packing up transport package zip...');
$builder->pack();

$mtime     = microtime();
$mtime     = explode(" ", $mtime);
$mtime     = $mtime[1] + $mtime[0];
$tend      = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

$modx->log(modX::LOG_LEVEL_INFO, "\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");

exit ();
