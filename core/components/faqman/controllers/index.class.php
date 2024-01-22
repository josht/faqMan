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
 */
/**
 * @package faqman
 * @subpackage controllers
 */
class FaqmanIndexManagerController extends modExtraManagerController {
    public $faqman;
    public function initialize() {
        $this->faqman = $this->modx->services->get('faqMan');
        $this->addCss($this->faqman->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->faqman->config['jsUrl'].'mgr/faqman.js');
        $this->addHtml('<script>
            Ext.onReady(function() {
                Faqman.config = ' . $this->modx->toJSON($this->faqman->config) . ';
                Faqman.config.connector_url = "' . $this->faqman->config['connectorUrl'] . '";
                Faqman.action = "' . (!empty($_REQUEST['a']) ? $_REQUEST['a'] : 'index') . '";
                Faqman.request = ' . $this->modx->toJSON($_GET) . ';
            });
        </script>');

        return parent::initialize();
    }

    public function getLanguageTopics() {
        return array('faqman:default');
    }

    public function checkPermissions() {
        return true;
    }

    public function process(array $scriptProperties = []) { }

    public function getPageTitle() {
        return $this->modx->lexicon('faqman');
    }

    public function loadCustomCssJs() {
        $this->addJavascript($this->faqman->config['jsUrl'] . 'mgr/widgets/sets.grid.js');
        $this->addJavascript($this->faqman->config['jsUrl'] . 'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->faqman->config['jsUrl'] . 'mgr/sections/home.js');
        $this->addHtml('<script>Ext.onReady(function() { MODx.load({xtype: "faqman-page-home"}) })</script>');
    }

    public function getTemplateFile() {
        return $this->faqman->config['templatesPath'] . 'home.tpl';
    }
}
