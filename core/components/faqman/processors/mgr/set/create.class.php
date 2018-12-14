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
 * Create an FAQ set
 *
 * @package faqman
 * @subpackage processors
 */
 class FaqmanSetCreateProcessor extends modObjectCreateProcessor {
    public $classKey = 'faqManSet';
    public $languageTopic = array('faqman:default');
    public $objectType = 'faqman.faqman';

    public function beforeSave() {
        $name = $this->getProperty('name');
        if (empty($name)) {
            $this->addFieldError('name',$this->modx->lexicon('faqman.set_err_ns_name'));
        } else if ($this->doesAlreadyExist(array('name' => $name))) {
            $this->addFieldError('name',$this->modx->lexicon('faqman.item_err_ae'));
        }

        $this->setRank();

        return parent::beforeSave();
    }

    /**
     * New FAQ Sets get added to the end of the list
     *
     * return void
     */
    private function setRank() {
        $count = $this->modx->getCount($this->classKey);
        $this->object->set('rank', $count);
    }
 }

 return 'FaqmanSetCreateProcessor';
