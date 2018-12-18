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
 * Resolve settings. These are useful to change if you want to debug and/or develop
 * in a directory outside of the MODx webroot. They are not required to set
 * for basic usage.
 *
 * @package faqman
 * @subpackage build
 */
function createSetting(&$modx,$key,$value) {
    $ct = $modx->getCount('modSystemSetting',array(
        'key' => 'faqman.'.$key,
    ));
    if (empty($ct)) {
        $setting = $modx->newObject('modSystemSetting');
        $setting->set('key','faqman.'.$key);
        $setting->set('value',$value);
        $setting->set('namespace','faqman');
        $setting->set('area','Paths');
        $setting->save();
    }
}
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $modx =& $object->xpdo;

            /* setup paths */
            //createSetting($modx,'faqman.core_path',$modx->getOption('core_path').'components/faqman/');
            //createSetting($modx,'faqman.assets_path',$modx->getOption('assets_path').'components/faqman/');

            /* setup urls */
            //createSetting($modx,'faqman.assets_url',$modx->getOption('assets_url').'components/faqman/');
        break;
    }
}
return true;
