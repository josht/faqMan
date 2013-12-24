<?php
/**
 * The base faqMan snippet.
 *
 * @package faqman
 */
$faqMan = $modx->getService('faqman', 'faqMan', $modx->getOption('faqman.core_path', null, $modx->getOption('core_path').'components/faqman/').'model/faqman/', $scriptProperties);
if (!($faqMan instanceof faqMan)) return '';

$set             = $modx->getOption('set', $scriptProperties, null);
$tpl             = $modx->getOption('tpl', $scriptProperties, 'Faqs');
$setTpl          = $modx->getOption('setTpl', $scriptProperties, null);
$sortBy          = $modx->getOption('sortBy', $scriptProperties, 'rank');
$sortDir         = $modx->getOption('sortDir', $scriptProperties, 'ASC');
$limit           = $modx->getOption('limit', $scriptProperties, null);
$showMenu        = $modx->getOption('showMenu', $scriptProperties, false);
$outputSeparator = $modx->getOption('outputSeparator', $scriptProperties, "\n");

/* build query */
$c = $modx->newQuery('faqManSet');
if (!empty($set)) {
    $c->where(array(
        'id' => $set,
    ));
} else {
    $c->sortby('id','ASC');
}
if (!empty($limit)) $c->limit($limit);

// Get collection of FAQ sets based on query
$sets = $modx->getCollection('faqManSet', $c);

// Loop through found FAQ sets and build the output
$list = array();
foreach ($sets as $set) {
    // Empty array to hold output from current set
    $setList  = array();
    $setArray = $set->toArray();

    // If no set template is defined, don't output set data
    if (!empty($setTpl)) {
        $setList[] = $faqMan->getChunk($setTpl, $setArray);
    }

    // Loop through items and set output to array
    $ci = $modx->newQuery('faqManItem');
    $ci->sortby($sortBy, $sortDir);
    foreach ($set->getMany('Item', $ci) as $item) {
        $itemArray = $item->toArray();
        if ($itemArray['type'] == faqMan::FAQ_TYPE_C) {
            $setList[] = $faqMan->getChunk($categoryTpl, $itemArray);
        } else {
            $setList[] = $faqMan->getChunk($tpl, $itemArray);
        }
    }

    // Collect output from this FAQ set.
    $list[] = implode("\n", $setList);
}

// Build output
$output = implode($outputSeparator, $list);
$toPlaceholder = $modx->getOption('toPlaceholder', $scriptProperties, false);
if (!empty($toPlaceholder)) {
    // If using a placeholder, output nothing and set output to specified placeholder
    $modx->setPlaceholder($toPlaceholder, $output);
    return '';
}

// By default just return output
return $output;