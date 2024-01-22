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
 */
namespace faqMan\Processors\Mgr\Item;

use MODX\Revolution\Processors\Model\UpdateProcessor;

/**
 * Sort two items. This was taken from the DD sort used by splittingred
 * in Gallery (https://github.com/splittingred/Gallery)
 *
 * @package faqman
 * @subpackage processors
 */
class Sort extends UpdateProcessor {
    public $classKey = faqManItem::class;
    public $languageTopic = array('faqman:default');
    public $objectType = 'faqman.faqman';

    public function initialize() {
        $primaryKey = $this->getProperty('source', false);
        $setKey = $this->getProperty('set', false);
        if (empty($primaryKey)) return $this->modx->lexicon($this->objectType.'_err_ns');
        if (empty($setKey)) return $this->modx->lexicon($this->objectType.'_err_ns');

        $this->object = $this->modx->getObject($this->classKey, [
            'set' => $setKey,
            'id'  => $primaryKey
            ]
        );

        if (empty($this->object)) return $this->modx->lexicon($this->objectType.'_err_nfs',array($this->primaryKeyField => $primaryKey));

        if ($this->checkSavePermission && $this->object instanceof modAccessibleObject && !$this->object->checkPolicy('save')) {
            return $this->modx->lexicon('access_denied');
        }

        return true;
    }

    /**
     * {@inheritDoc}
     * @return mixed
     */
    public function process() {
        /* Run the beforeSet method before setting the fields, and allow stoppage */
        $canSave = $this->beforeSet();
        if ($canSave !== true) {
            return $this->failure($canSave);
        }

        $request = $this->getProperties();

        $source = $this->object;

        $target = $this->modx->getObject($this->classKey, [
            'id'  => $this->getProperty('target', false),
            'set' => $this->getProperty('set', false)
        ]);

        if (empty($target)) {
            return $this->failure();
        }

        if ($source->get('rank') < $target->get('rank')) {
            $this->modx->exec("
                UPDATE {$this->modx->getTableName($this->classKey)}
                  SET rank = rank - 1
                WHERE
                  `set` = " . $this->getProperty('set', false) . "
                AND rank <= {$target->get('rank')}
                AND rank > {$source->get('rank')}
                AND rank > 0
            ");
            $newRank = $target->get('rank');
        } else {
            $this->modx->exec("
                UPDATE {$this->modx->getTableName($this->classKey)}
                  SET rank = rank + 1
                WHERE
                  `set` = " . $this->getProperty('set', false) . "
                AND rank >= {$target->get('rank')}
                AND rank < {$source->get('rank')}
            ");
            $newRank = $target->get('rank');
        }
        $source->set('rank', $newRank);
        $source->save();

        $this->afterSave();

        // Report source (dragged item) was changed
        $this->fireAfterSaveEvent();
        $this->logManagerAction();
        return $this->cleanup();
    }
}
