<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

require_once $namespace['path'] . 'vendor/autoload.php';

$modx->addPackage('faqMan\Model', $namespace['path'] . 'src/', null, 'faqMan\\');

$modx->services->add('faqMan', function() use ($modx) {
    return new faqMan\faqMan($modx);
});
