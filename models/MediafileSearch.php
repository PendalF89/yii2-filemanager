<?php

namespace douglasmk\filemanager\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "filemanager_mediafile".
 *
 * @property integer $id
 * @property string $filename
 * @property string $alt
 * @property string $palavras_chaves_arquivos
 */

class MediafileSearch extends Mediafile
{
    public $id;
    public $filename;
    public $alt;
    public $palavras_chaves_arquivos;
    public $preview;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['filename','alt','palavras_chaves_arquivos','preview'], 'string'],
            [['id','alt','filename'], 'safe']
        ];
    }

    /**
     * Creates data provider instance with search query applied
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Mediafile::find();
        $query->joinWith('vinculosArquivosPalavrasChaves.palavraChave', true, 'LEFT JOIN');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['updated_at'=>SORT_DESC, 'created_at'=>SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like','filename', $this->filename]);
        $query->andFilterWhere(['like','alt', $this->alt]);
        $query->andFilterWhere(['like','pch_palavra_chave', $this->palavras_chaves_arquivos]);
        $query->andFilterWhere(['like','filename', $this->preview]);

        $dataProvider->sort->attributes['id'] = [
            'asc' => ['id' => SORT_ASC],
            'desc' => ['id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['alt'] = [
            'asc' => ['alt' => SORT_ASC],
            'desc' => ['alt' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['filename'] = [
            'asc' => ['filename' => SORT_ASC],
            'desc' => ['filename' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['palavras_chaves_arquivos'] = [
            'asc' => ['pch_palavra_chave' => SORT_ASC],
            'desc' => ['pch_palavra_chave' => SORT_DESC],
        ];

        $dataProvider->setTotalCount(count(Mediafile::find()->all()));

        return $dataProvider;
    }
}
