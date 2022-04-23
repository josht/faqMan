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
 * Remove an Item.
 *
 * @package faqman
 * @subpackage processors
 */
class FaqmanItemRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'faqManItem';
    public $languageTopic = array('faqman:default');
    public $objectType = 'faqman.faqman';

    private $rank;
    private $set;

    /**
     * Get rank and set to use after removal
     *
     * @return boolean
     */
    public function beforeRemove() {
        $this->rank = $this->object->get('rank');
        $this->set  = $this->object->get('set');

        return !$this->hasErrors();
    }

    /**
     * Cleanup ranks after removal
     *
     * @return bool
     */
    public function afterRemove() {
        /**
         * If we made it here, then the item has been deleted. We now need to go through
         * each item below the removed spot and decrease each rank by 1 to keep ranks in order
         */
        $this->modx->exec("
            UPDATE {$this->modx->getTableName($this->classKey)}
            SET rank = rank - 1
            WHERE
            `set` = {$this->set}
            AND rank > {$this->rank}
            AND rank > 0
        ");
        return true;
    }
}

return 'FaqmanItemRemoveProcessor';
