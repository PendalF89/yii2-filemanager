<?php

namespace pendalf89\filemanager\models;

use Yii;
use pendalf89\filemanager\Module;

/**
 * This is the model class for table "filemanager_mediafiles".
 *
 * @property integer $id
 * @property integer $mediafile_id
 * @property integer $owner_id
 * @property string $owner
 * @property string $type
 *
 * @property Mediafile $mediafile
 */
class Mediafiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'filemanager_mediafiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mediafile_id', 'owner_id', 'owner', 'type'], 'required'],
            [['mediafile_id', 'owner_id'], 'integer'],
            [['owner', 'type'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('main', 'ID'),
            'mediafile_id' => Module::t('main', 'Mediafile ID'),
            'owner_id' => Module::t('main', 'Owner ID'),
            'owner' => Module::t('main', 'Owner'),
            'type' => Module::t('main', 'Type'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediafile()
    {
        return $this->hasOne(Mediafile::className(), ['id' => 'mediafile_id']);
    }
}
