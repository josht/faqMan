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
 * Get a list of Items
 *
 * @package faqman
 * @subpackage processors
 */
if (empty($scriptProperties['set'])) return $modx->error->failure($modx->lexicon('faqman.set_err_ns'));
// Get query options and set any defaults needed
$isLimit = !empty($_REQUEST['limit']);
$start   = $modx->getOption('start',$_REQUEST,0);
$limit   = $modx->getOption('limit',$_REQUEST,20);
$sort    = $modx->getOption('sort',$_REQUEST,'rank');
$dir     = $modx->getOption('dir',$_REQUEST,'ASC');
$search  = explode(' ', $modx->getOption('search', $_REQUEST, '')); // Get each word in search

// Init search query
$c = $modx->newQuery('faqManItem');
$c->where(array('set' => $scriptProperties['set']));

// Add search terms to query
foreach ($search as $term) {
  if (!empty($term)) {
    $c->where(array(
      array(
        'question:LIKE' => '%' . $term . '%')
      ),
      array(
        'OR:answer:LIKE' => '%' . $term . '%'
      )
    );
  }
}

// Get total count of items returned
$count = $modx->getCount('faqManItem',$c);

// Set query sort and limits and get items
$c->sortby($sort,$dir);
if ($isLimit) $c->limit($limit,$start);
$items = $modx->getCollection('faqManItem',$c);

// Get all returned items as array and return
$list = array();
foreach ($items as $item) {
  $itemArray = $item->toArray();
  $list[]= array_merge(
      $itemArray,
      array('actions' => array(
          array(
              'className' => 'edit',
              'text'      => 'Edit'
          ),
          array(
              'className' => 'delete',
              'text'      => 'Delete'
          ),
          array(
              'className' => ($itemArray['published']) ? 'unpublish' : 'publish orange',
              'text'      => ($itemArray['published']) ? 'Unpublish' : 'Publish'
          )
      ))
  );
}
return $this->outputArray($list,$count);
