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
 * faqMan Connector
 *
 * @package faqman
 */
if (!@include_once dirname(__FILE__, 5).'/config.core.php') {
    require_once dirname(__FILE__, 4).'/config.core.php';
}
require_once MODX_CORE_PATH.'config/'.MODX_CONFIG_KEY.'.inc.php';
require_once MODX_CONNECTORS_PATH.'index.php';

$corePath = $modx->getOption('faqman.core_path',null,$modx->getOption('core_path').'components/faqman/');
$modx->faqman = $modx->services->get('faqMan');

$modx->lexicon->load('faqman:default');

/* handle request */
$path = $modx->getOption('processorsPath',$modx->faqman->config,$corePath.'src/Processors/');
$modx->request->handleRequest(array(
    'processors_path' => $path,
    'location' => '',
));
