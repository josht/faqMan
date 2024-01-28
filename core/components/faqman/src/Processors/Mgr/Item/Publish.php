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
namespace faqMan\Processors\Mgr\Item;
use faqMan\Model\faqManItem;
use MODX\Revolution\Processors\Model\UpdateProcessor;

/**
 * Publish an Item
 *
 * @package faqman
 * @subpackage processors
 */
class Publish extends UpdateProcessor {
    public $classKey = faqManItem::class;
    public $languageTopic = array('faqman:default');
    public $objectType = 'faqman.faqman';

    public function beforeSave() {
        $this->object->set('published', 1);

        return true;
    }
}
