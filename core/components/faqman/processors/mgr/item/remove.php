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
/* get board */
if (empty($scriptProperties['id'])) return $modx->error->failure($modx->lexicon('faqman.item_err_ns'));
$item = $modx->getObject('faqManItem',$scriptProperties['id']);
if (!$item) return $modx->error->failure($modx->lexicon('faqman.item_err_nf'));

$set = $item->get('set');
$rank = $item->get('rank');

if ($item->remove() == false) {
    return $modx->error->failure($modx->lexicon('faqman.item_err_remove'));
}

/* If we made it here, then the item has been deleted. We now need to go through
 * each item below the removed spot and decrease each rank by 1 to make sure
 * ranks don't get messed up if we add an item after one has been removed
 */
$modx->exec("
    UPDATE {$modx->getTableName('faqManItem')}
      SET rank = rank - 1
    WHERE
      `set` = {$set}
    AND rank > {$rank}
    AND rank > 0
");

/* output */
return $modx->error->success('',$item);