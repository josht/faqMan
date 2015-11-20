<?php
/**
 * @package faqman
 */
$xpdo_meta_map['faqManSet']= array (
  'package' => 'faqman',
  'version' => '1.1',
  'table' => 'faqman_set',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => '',
    'description' => '',
    'rank' => 0,
    'published' => NULL,
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
    'published' => 
    array (
      'dbtype' => 'integer',
      'precision' => '1',
      'attributes' => 'unsigned',
      'phptype' => 'integer',
      'null' => false,
      'defaut' => '0',
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
