<?php

namespace douglasmk\filemanager\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use douglasmk\filemanager\Module;
use douglasmk\filemanager\models\Mediafile;
use douglasmk\filemanager\models\MediafileSearch;
use douglasmk\filemanager\models\VinculosArquivosPalavrasChaves;
use douglasmk\filemanager\models\VinculosArquivosReferencias;
use douglasmk\filemanager\assets\FilemanagerAsset;
use yii\helpers\Url;
use yii\helpers\Json;

use obsrepo\modules\palavraschave\models\PalavrasChave;

class ArquivoController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['post'],
                    //'update' => ['post'],
                    //'get-files' => ['post']
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (defined('YII_DEBUG') && YII_DEBUG) {
            Yii::$app->assetManager->forceCopy = true;
        }

        if(Yii::$app->request->get('modal')=='true'){
            $this->layout = '@vendor/douglasmk/yii2-filemanager/views/layouts/main';
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGerenciar()
    {

        $modelSearch = new MediafileSearch();
        $dataProvider = $modelSearch->search(Yii::$app->request->queryParams);

        return $this->render('filemanager', [
            'dataProvider' => $dataProvider,
            'modelSearch' => $modelSearch,
        ]);
    }

    public function actionUploadmanager()
    {
        return $this->render('uploadmanager', ['model' => new Mediafile()]);
    }

    /**
     * Provides upload file
     * @return mixed
     */
    public function actionUpload()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new Mediafile();
        $routes = $this->module->routes;
        $rename = $this->module->rename;
        $model->saveUploadedFile($routes, $rename);
        $bundle = FilemanagerAsset::register($this->view);

        if ($model->isImage()) {
            $model->createThumbs($routes, $this->module->thumbs);
        }

        $response['files'][] = [
            'url'           => $model->url,
            'thumbnailUrl'  => Yii::getAlias('@web').$model->getDefaultThumbUrl($bundle->baseUrl),
            'name'          => $model->filename,
            'type'          => $model->type,
            'size'          => $model->file->size,
            'deleteUrl'     => Url::to(['arquivo/delete', 'id' => $model->id]),
            'deleteType'    => 'POST',
            'updateUrl'     => Url::to(['arquivo/update', 'id' => $model->id]),
        ];

        return $response;
    }

    /**
     * Updated mediafile by id
     * @param $id
     * @return array
     */
    public function actionUpdate($id, $modal = 'false')
    {
        $model = Mediafile::findOne($id);
        $message = NULL;


        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // salva as novas palavras chaves se foram enviadas as palavras
            if (!empty($_POST['Mediafile']['palavras_chaves_arquivos'])) {
                $this->salvaVinculosPalavrasChaves($_POST['Mediafile']['palavras_chaves_arquivos'], $model->id);
            }
            
            // salva as referencias, se foram enviadas
            if (!empty($_POST['RefReferencias']['ref_id'])) {
                $this->salvaVinculosReferencias($_POST['RefReferencias']['ref_id'], $model->id);
            }

            $message = Module::t('main', 'Changes saved!');
        }


        $palavrasChavesData = [];
        foreach ($model->vinculosArquivosPalavrasChaves as $i => $vinculoPalavraChave) {
            $model->palavras_chaves_arquivos[$i] = $vinculoPalavraChave->palavraChave->pch_id;
            $palavrasChavesData[$i] = [$vinculoPalavraChave->palavraChave->pch_id => $vinculoPalavraChave->palavraChave->pch_palavra_chave];
        }

        Yii::$app->session->setFlash('mediafileUpdateResult', $message);

        return $this->render('info', [
            'palavrasChavesData' => $palavrasChavesData,
            'model' => $model,
            'strictThumb' => null,
        ]);
    }

    /**
     * Delete model with files
     * @param $id
     * @return array
     */
    public function actionDelete($id)
    {
        //Yii::$app->response->format = Response::FORMAT_JSON;
        $routes = $this->module->routes;

        $model = Mediafile::findOne($id);

        if($model->delete()){

            if ($model->isImage()) {
                $model->deleteThumbs($routes);
            }

            $model->deleteFile($routes);
        }

        $this->redirect(Url::to(['file/filemanager']));

        //return ['success' => 'true'];
    }

    /**
     * Resize all thumbnails
     */
    public function actionResize()
    {
        $models = Mediafile::findByTypes(Mediafile::$imageFileTypes);
        $routes = $this->module->routes;

        foreach ($models as $model) {
            if ($model->isImage()) {
                $model->deleteThumbs($routes);
                $model->createThumbs($routes, $this->module->thumbs);
            }
        }

        Yii::$app->session->setFlash('successResize');
        $this->redirect(Url::to(['default/settings']));
    }

    /** Render View
     * @param int $id
     * @return string
     */
    public function actionView($id)
    {
        $model = Mediafile::findOne($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /** Render model info
     * @param int $id
     * @param string $strictThumb only this thumb will be selected
     * @return string
     */
    public function actionGetFiles($ids)
    {
        $ids = explode(',', $ids);
        $models = [];
        foreach ($ids as $i=>$id) {
            $mediafile = Mediafile::findOne($id);
            $models[$i] = isset($mediafile) ? $mediafile->attributes : $mediafile;
            if(is_array($models[$i]))
                $models[$i]['icone'] = $mediafile->getThumbImage('small',['style' => 'font-size: 40px']);
        }
        echo json_encode($models);
    }



    /**
    *  ==========    PALAVRAS CHAVES    ===================
    */

    /**
     * @param null $search
     * @param null $id
     */
    public function actionPalavrasChavesLista($search = null, $id = null)
    {
        $out = ['items' => ['id' => 0, 'text' => 'Nenhum palavra chave encontrada.']];

        if (!is_null($search)) {
            $query = new \yii\db\Query;
            $query->select('pch_id as id, pch_palavra_chave AS text')
                    ->from('palavraschave.pch_palavras_chave')
                    ->where( ['like', 'pch_palavra_chave', [':pesquisa'=>trim($search)]] )
                    ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['items'] = array_values($data);
        }
        elseif ($id > 0) {

            $out['items'] = array();

            $palavrasChaves = VinculosArquivosPalavrasChaves::find()->where( ['vap_arquivo_id'=>(int)$id] )->all();

            // se há vinculos de palavras chaves , processa
            if ($palavrasChaves) {

                foreach ( $palavrasChaves as $idPalavraChave) {

                    $idPalavraChave = $idPalavraChave['vap_palavra_chave_id'];

                    $query = new \yii\db\Query;
                    /*$query->select('pch_id as id, pch_palavra_chave AS text')
                            ->from('palavraschave.pch_palavras_chave')
                            ->innerJoin('btt_vinculos_fichas_palavras_chaves', ' btt_vinculos_fichas_palavras_chaves.vfp_id_palavra_chave = btt_palavras_chaves.pch_id')
                            ->where('vfp_id_ficha=:id_ficha', [':id_ficha' => $id]);*/
                    $query->select('pch_id as id, pch_palavra_chave AS text')
                        ->from('palavraschave.pch_palavras_chave')
                        ->where('pch_id=:id_palavra_chave', [':id_palavra_chave' => $idPalavraChave]);
                    $command = $query->createCommand();
                    $data = $command->queryAll();

                    //$out['items'] = array_values($data);
                    array_push($out['items'], $data[0]);
                }
            } else {
                $out = ['items' => ['id' => 0, 'text' => 'Nenhuma palavra chave encontrada.']];
            }
        }

        echo Json::encode($out);
    }

    /*
    * Salva os vínculos das palavras chaves
    */
    public function salvaVinculosPalavrasChaves($tags, $idFicha) {
        // percorre as palavras chaves e adiciona-as no banco se não existir.
        foreach ($tags as $idPalavraChave ) {

            // verifica se é uma nova tag. Se for adiciona no banco.
            if (strpos($idPalavraChave,' (nova tag)') ) {

                $palavraChaveAlterada = str_replace(' (nova tag)', '', $idPalavraChave);

                if ($idPalavraChave != 'Nenhum registro encontrado.') {

                    // verifica se já nao existe a palavra chave
                    $buscaPalavraChave = PalavrasChave::find()->where(['pch_palavra_chave' => $palavraChaveAlterada])->one();

                    // nao existe a palavra chave, cadastra
                    if (!$buscaPalavraChave) {
                        $modelPalavraChave = new PalavrasChave();
                        $modelPalavraChave->pch_palavra_chave = $palavraChaveAlterada;
                        if ($modelPalavraChave->save()) {
                            $idPalavraChave = $modelPalavraChave->pch_id;
                        }
                    } else {
                        $idPalavraChave = $buscaPalavraChave->pch_id;
                    }
                }
            }

            // verifica se já existe o vínculo entre o ID da Imagem e o ID da Palavra Chave para nao duplicar
                $buscaIdFichaEIdPalavraChave = VinculosArquivosPalavrasChaves::find()->where([
                    'vap_arquivo_id' => $idFicha,
                    'vap_palavra_chave_id' => $idPalavraChave,
                ])->one();

            // se nao existir o vinculo, insere
                if ( !$buscaIdFichaEIdPalavraChave ) {
                    $modelVinculosPalavrasChaves = new VinculosArquivosPalavrasChaves();
                    $modelVinculosPalavrasChaves->vap_arquivo_id = $idFicha;
                    $modelVinculosPalavrasChaves->vap_palavra_chave_id = $idPalavraChave;
                    $modelVinculosPalavrasChaves->save(false);
                }
        }
    }
    
    

    /*
    * Salva os vínculos das palavras chaves
    */
    public function salvaVinculosReferencias($referencias, $idFicha) {
        
        // percorre os vinculos das referencias que foram removidas
        $vinculosParaRemover = VinculosArquivosReferencias::find()->where([
                    'var_arquivo_id' => $idFicha
                ])->where(['not in','var_referencia_id', $referencias])->all();
                
        if(isset($vinculosParaRemover)){        
            foreach ($vinculosParaRemover as $remover ) {
                $remover->delete();
            }
        }
        
        foreach ($referencias as $idReferencia ) {            

            // verifica se já existe o vínculo entre o ID da Imagem e o ID da Referência para nao duplicar
                $buscaIdFichaEIdReferencia = VinculosArquivosReferencias::find()->where([
                    'var_arquivo_id' => $idFicha,
                    'var_referencia_id' => $idReferencia,
                ])->one();

            // se nao existir o vinculo, insere
                if ( !$buscaIdFichaEIdReferencia ) {
                    $modelVinculosReferencias = new VinculosArquivosReferencias();
                    $modelVinculosReferencias->var_arquivo_id = $idFicha;
                    $modelVinculosReferencias->var_referencia_id = $idReferencia;
                    $modelVinculosReferencias->save(false);
                }
        }
    }

}
