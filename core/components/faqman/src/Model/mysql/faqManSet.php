<?php
namespace faqMan\Model\mysql;

use xPDO\xPDO;

class faqManSet extends \faqMan\Model\faqManSet
{

    public static $metaMap = array (
        'package' => 'faqMan\\Model',
        'version' => '3.0',
        'table' => 'faqman_set',
        'extends' => 'xPDO\\Om\\xPDOSimpleObject',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'name' => '',
            'description' => '',
            'rank' => 0,
            'published' => 1,
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
            'published' => 
            array (
                'dbtype' => 'integer',
                'precision' => '1',
                'attributes' => 'unsigned',
                'phptype' => 'integer',
                'null' => false,
                'default' => 1,
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

}
