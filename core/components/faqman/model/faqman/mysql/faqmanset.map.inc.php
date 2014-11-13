<?php
/**
 * @package faqman
 */
$xpdo_meta_map['faqManSet']= array (
  'package' => 'faqman',
  'version' => NULL,
  'table' => 'faqman_set',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
    'rank' => '',
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'description' => 
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
  ),
  'composites' => 
  array (
    'Item' => 
    array (
      'class' => 'faqManItem',
      'local' => 'id',
      'foreign' => 'set',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);
