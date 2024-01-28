<?php
/**
 * snippet to list faq sets and their questions
 *
 * contributed by Christian Seel <cs@chsmedien.de>
 *
 * @package faqman
 */
use faqMan\Model\faqManSet;
use faqMan\Model\faqManItem;

$faqMan = $modx->services->get('faqMan');
if (!($faqMan instanceof faqMan\faqMan)) return '';

$set = $modx->getOption('set',$scriptProperties,null);
$tpl = $modx->getOption('tpl',$scriptProperties,'Faqs');
$questionTpl = $modx->getOption('questionTpl',$scriptProperties,'Faqs');
$sortBy = $modx->getOption('sortBy',$scriptProperties,'name');
$sortDir = $modx->getOption('sortDir',$scriptProperties,'ASC');
$limit = $modx->getOption('limit',$scriptProperties,null);
$limitQuestions = $modx->getOption('limitQuestions',$scriptProperties,5);
$outputSeparator = $modx->getOption('outputSeparator',$scriptProperties,"\n");
$questionOutputSeparator = $modx->getOption('questionOutputSeparator',$scriptProperties,"\n");
$showUnpublished = $modx->getOption('showUnpublished', $scriptProperties, false);

/* build query */
$c = $modx->newQuery(faqManSet::class);

if (!empty($set)) {
    $field = (is_numeric($set)) ? 'id' : 'name';
    $c->where(array(
        $field => $set,
    ));
}

// Hide unpublished sets
if (!$showUnpublished) {
    $c->where(array('published' => true));
}

$c->sortby($modx->quote($sortBy),$sortDir);
if (!empty($limit)) $c->limit($limit);
$items = $modx->getCollection(faqManSet::class,$c);

/* iterate through items */
$list = array();

$si = 0;
foreach ($items as $item) {
    $si++;
    $itemArray = $item->toArray();
    $itemArray['setidx'] = $si;

    // get faqManItems of this set
    $criteria = $modx->newQuery(faqManItem::class);
    if (!$showUnpublished) {
        $criteria->where(array('published' => true));
    }
    $criteria->sortby($modx->quote('rank'),'ASC');
    $criteria->limit($limitQuestions);
    $questions = $item->getMany('Item',$criteria);

    $questionlist = array();
    $qi = 0;
    foreach ($questions as $q) {
        $qi++;
    	$qArray = $q->toArray();
        $qArray['idx'] = $qi;
    	$qArray['set_name'] = $itemArray['name'];
	    $questionlist[] = $faqMan->getChunk($questionTpl,$qArray);
    }
    $itemArray['questions'] = implode($questionOutputSeparator,$questionlist);

    $list[] = $faqMan->getChunk($tpl,$itemArray);
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
