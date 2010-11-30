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
 * Loads the header for mgr pages.
 *
 * @package faqman
 * @subpackage controllers
 */
$modx->regClientCSS($faqMan->config['cssUrl'].'mgr.css');
$modx->regClientStartupScript($faqMan->config['jsUrl'].'mgr/faqman.js');
$modx->regClientStartupHTMLBlock('<script type="text/javascript">
Ext.onReady(function() {
    faqMan.config = '.$modx->toJSON($faqMan->config).';
    faqMan.config.connector_url = "'.$faqMan->config['connectorUrl'].'";
    faqMan.action = "'.(!empty($_REQUEST['a']) ? $_REQUEST['a'] : 0).'";
    faqMan.request = '.$modx->toJSON($_GET).';
});
</script>');

return '';