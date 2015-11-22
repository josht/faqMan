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
 * Resolve changes made to DB tables
 *
 * @package faqman
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            /** @var modX $modx */
            $modx      =& $object->xpdo;
            $modelPath = $modx->getOption('faqman.core_path',null,$modx->getOption('core_path').'components/faqman/').'model/';
            $modx->addPackage('faqman',$modelPath);

            /** @var xPDOManager $manager */
            $manager = $modx->getManager();

            $oldLogLevel = $modx->getLogLevel();
            $modx->setLogLevel(0);

            /** 1.2 */
            $manager->addField('faqManItem', 'published');
            $manager->addField('faqManSet', 'published');
            $manager->addField('faqManSet', 'rank');

            /** 1.0.3 */
            $manager->alterField('faqManItem', 'question');


            $modx->setLogLevel($oldLogLevel);
            break;
    }
}
return true;
