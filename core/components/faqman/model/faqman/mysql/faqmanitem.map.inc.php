<?php
/**
 * @package faqman
 */
$xpdo_meta_map['faqManItem']= array (
  'package' => 'faqman',
  'table' => 'faqman_items',
  'fields' => 
  array (
    'question' => '',
    'answer' => '',
    'rank' => 0,
    'type' => NULL,
    'set' => 0,
  ),
  'fieldMeta' => 
  array (
    'question' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'answer' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'text',
      'null' => false,
      'default' => '',
    ),
    'rank' => 
    array (
      'dbtype' => 'integer',
      'precision' => '5',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'type' => 
    array (
      'dbtype' => 'integer',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'defaut' => '0',
    ),
    'set' => 
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
      'index' => 'index',
    ),
  ),
  'aggregates' => 
  array (
    'Set' => 
    array (
      'class' => 'faqManSet',
      'local' => 'set',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
