<?php

namespace douglasmk\filemanager\models;

use Yii;
use obsrepo\modules\palavraschave\models\PalavrasChave;

/**
 * This is the model class for table "{{%vinculos_fichas_palavras_chaves}}".
 *
 * @property integer $vfp_id
 * @property integer $vfp_id_ficha
 * @property integer $vfp_id_palavra_chave
 *
 * @property Fichas $vfpIdFicha
 * @property PalavrasChaves $vfpIdPalavraChave
 */
class VinculosArquivosPalavrasChaves extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        //return 'filemanager_mediafile';
		return Yii::$app->getModule('arquivos')->vinculos_palavras_chaves_table;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vap_arquivo_id', 'vap_palavra_chave_id'], 'required'],
            [['vap_arquivo_id', 'vap_palavra_chave_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'vap_id' => Yii::t('btt', 'Id'),
            'vap_arquivo_id' => Yii::t('btt', 'Arquivo'),
            'vap_palavra_chave_id' => Yii::t('btt', 'Palavra Chave'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArquivo()
    {
        return $this->hasOne( Mediafile::className(), ['id' => 'vap_arquivo_id'] );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalavraChave()
    {
        return $this->hasOne( PalavrasChave::className(), ['pch_id' => 'vap_palavra_chave_id'] );
    }
}
