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
 * Create an FAQ set
 *
 * @package faqman
 * @subpackage processors
 */
$alreadyExists = $modx->getObject('faqManSet',array(
    'name' => $_POST['name'],
));
if ($alreadyExists) {
    $modx->error->addField('name',$modx->lexicon('faqman.item_err_ae'));
}

if ($modx->error->hasError()) {
    return $modx->error->failure();
}

$set = $modx->newObject('faqManSet');
$set->fromArray($_POST);

// Set rank to last in list
$total = $modx->getCount('faqManSet');
$set->set('rank',$total);

if ($set->save() == false) {
    return $modx->error->failure($modx->lexicon('faqman.set_err_save'));
}

return $modx->error->success('',$set);