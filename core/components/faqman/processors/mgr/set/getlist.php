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
 * Get a list of FAQ sets
 *
 * @package faqman
 * @subpackage processors
 */
$isLimit = !empty($_REQUEST['limit']);
$start   = $modx->getOption('start',$_REQUEST,0);
$limit   = $modx->getOption('limit',$_REQUEST,20);
$sort    = $modx->getOption('sort',$_REQUEST,'rank');
$dir     = $modx->getOption('dir',$_REQUEST,'ASC');

// Build query
$c     = $modx->newQuery('faqManSet');
$count = $modx->getCount('faqManSet',$c);
$c->sortby($sort, $dir);
if ($isLimit) $c->limit($limit, $start);
$sets = $modx->getCollection('faqManSet', $c);

// Build output and return
$list = array();
foreach ($sets as $set) {
    $setArray = $set->toArray();
    $list[]   = $setArray;
}
return $this->outputArray($list, $count);
