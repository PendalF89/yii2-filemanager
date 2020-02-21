<?php

namespace pendalf89\filemanager\models;

use Yii;

/**
 * This is the model class for table "filemanager_mediafiles".
 *
 * @property integer $mediafile_id
 * @property integer $owner_id
 * @property string $owner
 * @property string $owner_attribute
 *
 * @property Mediafile $mediafile
 */
class Owners extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filemanager_owners}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mediafile_id', 'owner_id', 'owner_attribute', 'owner'], 'required'],
            [['mediafile_id', 'owner_id'], 'integer'],
            [['owner', 'owner_attribute'], 'string', 'max' => 255]
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
