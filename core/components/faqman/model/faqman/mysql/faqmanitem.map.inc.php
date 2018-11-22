<?php
/**
 * @package faqman
 */
$xpdo_meta_map['faqManItem']= array (
  'package' => 'faqman',
  'version' => '1.1',
  'table' => 'faqman_items',
  'extends' => 'xPDOSimpleObject',
  'fields' =>
  array (
    'question' => '',
    'answer' => '',
    'rank' => 0,
    'type' => 0,
    'published' => 1,
    'set' => 0,
  ),
  'fieldMeta' =>
  array (
    'question' =>
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'answer' =>
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
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
      'default' => 0,
    ),
    'published' =>
    array (
      'dbtype' => 'integer',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'default' => 1,
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
