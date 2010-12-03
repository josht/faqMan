<?php
/**
 * @package faqman
 */
$xpdo_meta_map['faqManSet']= array (
  'package' => 'faqman',
  'table' => 'faqman_set',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
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
