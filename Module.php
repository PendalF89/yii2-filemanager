<?php

namespace douglasmk\filemanager;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'douglasmk\filemanager\controllers';

    /**
     *  Set true if you want to rename files if the name is already in use
     * @var bolean
     */
    public $rename = false;

     /**
     *  Set true to enable autoupload
     * @var bolean
     */
    public $autoUpload = false;

    /**
     * @var array upload routes
     */
    public $routes = [
        // base absolute path to web directory
        'baseUrl' => '',
        // base web directory url
        'basePath' => '@webroot',
        // path for uploaded files in web directory
        'uploadPath' => 'uploads',
    ];

    /**
     * @var array thumbnails info
     */
    public $thumbs = [
        'small' => [
            'name' => 'Small size',
            'size' => [120, 80],
        ],
        'medium' => [
            'name' => 'Medium size',
            'size' => [400, 300],
        ],
        'large' => [
            'name' => 'Large size',
            'size' => [800, 600],
        ],
    ];

    /**
     * @var array default thumbnail size, using in filemanager view.
     */
    private static $defaultThumbSize = [128, 128];


    	/**
	 * Table aliases
	 *
	 * @var string
	 */

	public $mediafile_table = '{{%mediafile}}';
	public $owners_table = '{{%owners}}';
	public $vinculos_palavras_chaves_table = '{{%vinculos_palavras_chaves_table}}';
	public $vinculos_referencias_table = '{{%vinculos_referencias_table}}';

    public function init()
    {
        parent::init();
        $this->registerTranslations();
    }

    public function registerTranslations()
    {
        Yii::$app->i18n->translations['modules/filemanager/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/douglasmk/yii2-filemanager/messages',
            'fileMap' => [
                'modules/filemanager/main' => 'main.php',
            ],
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        if (!isset(Yii::$app->i18n->translations['modules/filemanager/*'])) {
            return $message;
        }

        return Yii::t("modules/filemanager/$category", $message, $params, $language);
    }

    /**
     * @return array default thumbnail size. Using in filemanager view.
     */
    public static function getDefaultThumbSize()
    {
        return self::$defaultThumbSize;
    }
}
