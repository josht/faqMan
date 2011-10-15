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
 * Loads system settings into build
 *
 * @package faqman
 * @subpackage build
 */
$settings = array();

/*
$settings['gallery.']= $modx->newObject('modSystemSetting');
$settings['gallery.']->fromArray(array(
    'key' => 'gallery.',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'gallery',
    'area' => '',
),'',true,true);
*/


/* Settings for the TinyMCE integration */
$settings['faqman.use_richtext']= $modx->newObject('modSystemSetting');
$settings['faqman.use_richtext']->fromArray(array(
    'key' => 'faqman.use_richtext',
    'value' => true,
    'xtype' => 'combo-boolean',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.width']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.width']->fromArray(array(
    'key' => 'faqman.tiny.width',
    'value' => '95%',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.height']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.height']->fromArray(array(
    'key' => 'faqman.tiny.height',
    'value' => 200,
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.buttons1']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.buttons1']->fromArray(array(
    'key' => 'faqman.tiny.buttons1',
    'value' => 'undo,redo,selectall,pastetext,pasteword,charmap,separator,image,modxlink,unlink,media,separator,code,help',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.buttons2']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.buttons2']->fromArray(array(
    'key' => 'faqman.tiny.buttons2',
    'value' => 'bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,outdent,indent,separator,justifyleft,justifycenter,justifyright,justifyfull',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.buttons3']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.buttons3']->fromArray(array(
    'key' => 'faqman.tiny.buttons3',
    'value' => 'styleselect,formatselect,separator,styleprops',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.buttons4']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.buttons4']->fromArray(array(
    'key' => 'faqman.tiny.buttons4',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.buttons5']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.buttons5']->fromArray(array(
    'key' => 'faqman.tiny.buttons5',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.custom_plugins']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.custom_plugins']->fromArray(array(
    'key' => 'faqman.tiny.custom_plugins',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.theme']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.theme']->fromArray(array(
    'key' => 'faqman.tiny.theme',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.theme_advanced_blockformats']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.theme_advanced_blockformats']->fromArray(array(
    'key' => 'faqman.tiny.theme_advanced_blockformats',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

$settings['faqman.tiny.theme_advanced_css_selectors']= $modx->newObject('modSystemSetting');
$settings['faqman.tiny.theme_advanced_css_selectors']->fromArray(array(
    'key' => 'faqman.tiny.theme_advanced_css_selectors',
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'faqman',
    'area' => 'TinyMCE',
),'',true,true);

return $settings;