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
 * Loads all FAQ's in the specified set.
 *
 * @package faqman
 * @subpackage controllers
 */
$modx->regClientStartupScript($faqMan->config['jsUrl'].'mgr/widgets/items.grid.js');
$modx->regClientStartupScript($faqMan->config['jsUrl'].'mgr/widgets/set.panel.js');
$modx->regClientStartupScript($faqMan->config['jsUrl'].'mgr/sections/set.js');
$output = '<div id="faqman-panel-set-div"></div>';

/* If we want to use Tiny, we'll need some extra files. */
$useTiny = $modx->getOption('faqman.use_richtext',$faqMan->config,false);
if ($useTiny) {
    $tinyCorePath = $modx->getOption('tiny.core_path',null,$modx->getOption('core_path').'components/tinymce/');
    /* Make sure Tiny is installed by checking the core class file */
    if (file_exists($tinyCorePath.'tinymce.class.php')) {

        /* First fetch the faqman+tiny specific settings */
        $cb1 =  $modx->getOption('faqman.tiny.buttons1',null,'undo,redo,selectall,pastetext,pasteword,charmap,separator,image,modxlink,unlink,media,separator,code,help');
        $cb2 =  $modx->getOption('faqman.tiny.buttons2',null,'bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,outdent,indent,separator,justifyleft,justifycenter,justifyright,justifyfull');
        $cb3 =  $modx->getOption('faqman.tiny.buttons3',null,'styleselect,formatselect,separator,styleprops');
        $cb4 =  $modx->getOption('faqman.tiny.buttons4',null,'');
        $cb5 =  $modx->getOption('faqman.tiny.buttons5',null,'');
        $plugins =  $modx->getOption('faqman.tiny.custom_plugins',null,'');
        $theme =  $modx->getOption('faqman.tiny.theme',null,'');
        $bfs =  $modx->getOption('faqman.tiny.theme_advanced_blockformats',null,'');
        $css =  $modx->getOption('faqman.tiny.theme_advanced_css_selectors',null,'');

        /* If the settings are empty, override them with the generic tinymce settings. */
        $tinyProperties = array(
            'height' => $modx->getOption('faqman.tiny.height',null,200),
            'width' => $modx->getOption('faqman.tiny.width',null,'95%'),
            'tiny.custom_buttons1' => (!empty($cb1)) ? $cb1 : $modx->getOption('tiny.custom_buttons1',null,'undo,redo,selectall,separator,pastetext,pasteword,separator,search,replace,separator,nonbreaking,hr,charmap,separator,image,modxlink,unlink,anchor,media,separator,cleanup,removeformat,separator,fullscreen,print,code,help'),
            'tiny.custom_buttons2' => (!empty($cb2)) ? $cb2 : $modx->getOption('tiny.custom_buttons2',null,'bold,italic,underline,strikethrough,sub,sup,separator,bullist,numlist,outdent,indent,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,styleselect,formatselect,separator,styleprops'),
            'tiny.custom_buttons3' => (!empty($cb3)) ? $cb3 : $modx->getOption('tiny.custom_buttons3',null,''),
            'tiny.custom_buttons4' => (!empty($cb4)) ? $cb4 : $modx->getOption('tiny.custom_buttons4',null,''),
            'tiny.custom_buttons5' => (!empty($cb5)) ? $cb5 : $modx->getOption('tiny.custom_buttons5',null,''),
            'tiny.custom_plugins' => (!empty($plugins)) ? $plugins : $modx->getOption('tiny.custom_plugins',null,'style,advimage,advlink,modxlink,searchreplace,print,contextmenu,paste,fullscreen,noneditable,nonbreaking,xhtmlxtras,visualchars,media'),
            'tiny.editor_theme' => (!empty($theme)) ? $theme : $modx->getOption('tiny.editor_theme',null,'cirkuit'),
            'tiny.skin_variant' => $modx->getOption('tiny.skin_variant',null,''),
            'tiny.theme_advanced_blockformats' => (!empty($bfs)) ? $bfs : $modx->getOption('tiny.theme_advanced_blockformats',null,'p,h1,h2,h3,h4,h5,h6,div,blockquote,code,pre,address'),
            'tiny.css_selectors' => (!empty($css)) ? $css : $modx->getOption('tiny.css_selectors',null,''),
        );
        require_once $tinyCorePath.'tinymce.class.php';
        $tiny = new TinyMCE($modx,$tinyProperties);
        $tiny->setProperties($tinyProperties);
        $html = $tiny->initialize();
        $modx->regClientHTMLBlock($html);
    }
}

return $output;
