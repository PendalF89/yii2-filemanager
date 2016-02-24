<?php

namespace douglasmk\filemanager\models;

use Yii;
use obsrepo\obsref\models\RefReferencias;

/**
 * This is the model class for table "{{%vinculos_referencias_table}}".
 *
 * @property integer $var_id
 * @property integer $var_arquivo_id
 * @property integer $var_referencia_id
 *
 */
class VinculosArquivosReferencias extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        //return 'filemanager_mediafile';
		return Yii::$app->getModule('arquivos')->vinculos_referencias_table;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['var_arquivo_id', 'var_referencia_id'], 'required'],
            [['var_arquivo_id', 'var_referencia_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'var_id' => Yii::t('btt', 'Id'),
            'var_arquivo_id' => Yii::t('btt', 'Arquivo'),
            'var_referencia_id' => Yii::t('btt', 'Referência'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArquivo()
    {
        return $this->hasOne( Mediafile::className(), ['id' => 'var_arquivo_id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReferencias()
    {
        return $this->hasOne( RefReferencias::className(), ['ref_id' => 'var_referencia_id'] );
    }
}
