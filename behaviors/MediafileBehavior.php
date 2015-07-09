<?php
namespace pendalf89\filemanager\behaviors;

use yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use pendalf89\filemanager\models\Mediafile;

class MediafileBehavior extends Behavior
{
    /**
     * @var string owner name
     */
    public $name = '';

    /**
     * @var array owner mediafiles attributes names
     */
    public $attributes = [];

    /**
     * @inheritdoc
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'addOwners',
            ActiveRecord::EVENT_AFTER_UPDATE => 'updateOwners',
            ActiveRecord::EVENT_BEFORE_DELETE => 'deleteOwners',
        ];
    }

    /**
     * Add owners to mediafile
     */
    public function addOwners()
    {
        foreach ($this->attributes as $attr) {
            if ($mediafile = $this->loadModel($this->owner->$attr)) {
                $mediafile->addOwner($this->owner->primaryKey, $this->name, $attr);
            }
        }
    }

    /**
     * Update owners of mediafile
     */
    public function updateOwners()
    {
        foreach ($this->attributes as $attr) {
            Mediafile::removeOwner($this->owner->primaryKey, $this->name, $attr);

            if ($mediafile = $this->loadModel($this->owner->$attr)) {
                $mediafile->addOwner($this->owner->primaryKey, $this->name, $attr);
            }
        }
    }

    /**
     * Delete owners of mediafile
     */
    public function deleteOwners()
    {
        foreach ($this->attributes as $attr) {
            Mediafile::removeOwner($this->owner->primaryKey, $this->name, $attr);
        }
    }

    /**
     * Load model by id
     * @param int $id
     * @return Mediafile
     */
    private function loadModel($id)
    {
        return Mediafile::findOne($id);
    }
}