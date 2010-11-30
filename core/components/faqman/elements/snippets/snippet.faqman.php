<?php
/**
 * The base faqMan snippet.
 *
 * @package faqman
 */
$faqMan = $modx->getService('faqman','faqMan',$modx->getOption('faqman.core_path',null,$modx->getOption('core_path').'components/faqman/').'model/faqman/',$scriptProperties);
if (!($faqMan instanceof faqMan)) return '';

$set = $modx->getOption('set',$scriptProperties,null);
$tpl = $modx->getOption('tpl',$scriptProperties,'Faqs');
$categoryTpl = $modx->getOption('categoryTpl',$scriptProperties,'categoryTpl');
$sortBy = $modx->getOption('sortBy',$scriptProperties,'rank');
$sortDir = $modx->getOption('sortDir',$scriptProperties,'ASC');
$limit = $modx->getOption('limit',$scriptProperties,null);
$showMenu = $modx->getOption('showMenu',$scriptProperties,false);
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");

/* build query */
$c = $modx->newQuery('faqManItem');

if (!empty($set)) {
    $c->where(array(
        '`set`' => $set,
    ));
} else {
    $c->sortby('`set`','ASC');
}

$c->sortby($sortBy,$sortDir);

if (!empty($limit)) $c->limit($limit);

$items = $modx->getCollection('faqManItem',$c);

/* iterate through items */
$list = array();

/* show a menu of FAQ's that will link down to the actual FAQ */
if ($showMenu) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Option not implemented: showMenu');
}

foreach ($items as $item) {
    $itemArray = $item->toArray();
    if ($itemArray['type'] == faqMan::FAQ_TYPE_C) {
        $list[] = $faqMan->getChunk($categoryTpl,$itemArray);
    } else {
        $list[] = $faqMan->getChunk($tpl,$itemArray);
    }
}

/* output */
$output = implode($outputSeparator,$list);
$toPlaceholder = $modx->getOption('toPlaceholder',$scriptProperties,false);
if (!empty($toPlaceholder)) {
    /* if using a placeholder, output nothing and set output to specified placeholder */
    $modx->setPlaceholder($toPlaceholder,$output);
    return '';
}
/* by default just return output */
return $output;