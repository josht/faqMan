<?php
namespace faqMan\Model\mysql;

use xPDO\xPDO;

class faqManItem extends \faqMan\Model\faqManItem
{

    public static $metaMap = array (
        'package' => 'faqMan\\Model',
        'version' => '3.0',
        'table' => 'faqman_items',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'question' => '',
            'answer' => '',
            'author' => '',
            'createdAt' => NULL,
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
            'author' => 
            array (
                'dbtype' => 'tinytext',
                'phptype' => 'string',
                'null' => true,
                'default' => '',
            ),
            'createdAt' => 
            array (
                'dbtype' => 'timestamp',
                'phptype' => 'string',
                'null' => false,
                'attributes' => 'DEFAULT CURRENT_TIMESTAMP',
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
                'class' => 'faqMan\\Model\\faqManSet',
                'local' => 'set',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
        ),
    );

}
