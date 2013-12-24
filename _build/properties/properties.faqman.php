<?php
/**
 * faqMan
 *
 * Copyright 2010 by Josh Tambunga <josh+faqman@joshsmind.com>
 *
 * faqMan is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * faqMan is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * faqMan; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package faqman
 */
/**
 * Properties for the faqMan snippet.
 *
 * @package faqman
 * @subpackage build
 */
$properties = array(
    array(
        'name'    => 'tpl',
        'desc'    => 'prop_faqman.tpl_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'Faqs',
        'lexicon' => 'faqman:properties',
    ),
    array(
        'name'    => 'setTpl',
        'desc'    => 'prop_faqman.tpl_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'Faqs',
        'lexicon' => 'faqman:properties',
    ),
    array(
        'name'    => 'sortBy',
        'desc'    => 'prop_faqman.sortby_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'rank',
        'lexicon' => 'faqman:properties',
    ),
    array(
        'name'    => 'sortDir',
        'desc'    => 'prop_faqman.sortdir_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => 'ASC',
        'lexicon' => 'faqman:properties',
    ),
    array(
        'name'    => 'outputSeparator',
        'desc'    => 'prop_faqman.outputseparator_desc',
        'type'    => 'textfield',
        'options' => '',
        'value'   => "\n",
        'lexicon' => 'faqman:properties',
    ),
    array(
        'name'    => 'toPlaceholder',
        'desc'    => 'prop_faqman.toplaceholder_desc',
        'type'    => 'combo-boolean',
        'options' => '',
        'value'   => false,
        'lexicon' => 'faqman:properties',
    ),
/*
    array(
        'name'    => '',
        'desc'    => 'prop_faqman.',
        'type'    => 'textfield',
        'options' => '',
        'value'   => '',
        'lexicon' => 'faqman:properties',
    ),
    */
);

return $properties;