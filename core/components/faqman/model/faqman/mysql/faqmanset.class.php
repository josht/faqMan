<?php
/**
 * @package faqman
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/faqmanset.class.php');
class faqManSet_mysql extends faqManSet {}
?>