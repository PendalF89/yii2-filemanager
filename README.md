Yii2 file manager
================
This module provide interface to collect and access all mediafiles in one place. Inspired by WordPress file manager.

Features
------------
* Integrated with TinyMCE editor.
* Automatically create actually directory for uploaded files like "2014/12".
* Automatically create thumbs for uploaded images
* Unlimited number of sets of miniatures
* All media files are stored in a database that allows you to attach to your object does not link to the image, and the id of the media file. This provides greater flexibility since in the future will be easy to change the size of thumbnails.
* If your change thumbs sizes, your may resize all existing thumbs in settings.

Screenshots
------------
<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-upload.png">

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-image-select.png">

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-index.png">

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-files-in-admin.png">

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-settings.png">

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-selected-image.png">

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-selected-image-without-input.png">

Installation
------------
The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pendalf89/yii2-filemanager "*"
```

or add

```
"pendalf89/yii2-filemanager": "*"
```

to the require section of your `composer.json` file.

Apply migration
```sh
yii migrate --migrationPath=vendor/pendalf89/yii2-filemanager/migrations
```

Configuration:

```php
'modules' => [
    'filemanager' => [
        'class' => 'pendalf89\filemanager\Module',
        // Upload routes
        'routes' => [
            // Base absolute path to web directory
            'baseUrl' => '',
            // Base web directory url
            'basePath' => '@frontend/web',
            // Path for uploaded files in web directory
            'uploadPath' => 'uploads',
        ],
        // Thumbnails info
        'thumbs' => [
            'small' => [
                'name' => 'Мелкий',
                'size' => [100, 100],
            ],
            'medium' => [
                'name' => 'Средний',
                'size' => [300, 200],
            ],
            'large' => [
                'name' => 'Большой',
                'size' => [500, 400],
            ],
        ],
    ],
],
```
By default, thumbnails are resized in "outbound" or "fill" mode. To switch to "inset" or "fit" mode, use `mode` parameter and provide. Possible values: `outbound` (`\Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND`) or `inset` (`\Imagine\Image\ImageInterface::THUMBNAIL_INSET`):

```php
'thumbs' => [
    'small' => [
        'name' => 'Мелкий',
        'size' => [100, 100],
    ],
    'medium' => [
        'name' => 'Средний',
        'size' => [300, 200],
    ],
    'large' => [
        'name' => 'Большой',
        'size' => [500, 400],
        'mode' => \Imagine\Image\ImageInterface::THUMBNAIL_INSET
    ],
],
```

Usage
------------
Simple standalone field:

```php
use pendalf89\filemanager\widgets\FileInput;

echo $form->field($model, 'original_thumbnail')->widget(FileInput::className(), [
    'buttonTag' => 'button',
    'buttonName' => 'Browse',
    'buttonOptions' => ['class' => 'btn btn-default'],
    'options' => ['class' => 'form-control'],
    // Widget template
    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    // Optional, if set, only this image can be selected by user
    'thumb' => 'original',
    // Optional, if set, in container will be inserted selected image
    'imageContainer' => '.img',
    // Default to FileInput::DATA_URL. This data will be inserted in input field
    'pasteData' => FileInput::DATA_URL,
    // JavaScript function, which will be called before insert file data to input.
    // Argument data contains file data.
    // data example: [alt: "Ведьма с кошкой", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
    'callbackBeforeInsert' => 'function(e, data) {
        console.log( data );
    }',
]);

echo FileInput::widget([
    'name' => 'mediafile',
    'buttonTag' => 'button',
    'buttonName' => 'Browse',
    'buttonOptions' => ['class' => 'btn btn-default'],
    'options' => ['class' => 'form-control'],
    // Widget template
    'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
    // Optional, if set, only this image can be selected by user
    'thumb' => 'original',
    // Optional, if set, in container will be inserted selected image
    'imageContainer' => '.img',
    // Default to FileInput::DATA_URL. This data will be inserted in input field
    'pasteData' => FileInput::DATA_URL,
    // JavaScript function, which will be called before insert file data to input.
    // Argument data contains file data.
    // data example: [alt: "Ведьма с кошкой", description: "123", url: "/uploads/2014/12/vedma-100x100.jpeg", id: "45"]
    'callbackBeforeInsert' => 'function(e, data) {
        console.log( data );
    }',
]);
```

With TinyMCE:
```php
use pendalf89\filemanager\widgets\TinyMCE;

<?= $form->field($model, 'content')->widget(TinyMCE::className(), [
    'clientOptions' => [
           'language' => 'ru',
        'menubar' => false,
        'height' => 500,
        'image_dimensions' => false,
        'plugins' => [
            'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table',
        ],
        'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
    ],
]); ?>
```

In model you must set mediafile behavior like this example:

```php
use pendalf89\filemanager\behaviors\MediafileBehavior;

public function behaviors()
{
    return [
        'mediafile' => [
            'class' => MediafileBehavior::className(),
            'name' => 'post',
            'attributes' => [
                'thumbnail',
            ],
        ]
    ];
}
```

Than, you may get mediafile from your owner model.
See example:

```php
use pendalf89\filemanager\models\Mediafile;

$model = Post::findOne(1);
$mediafile = Mediafile::loadOneByOwner('post', $model->id, 'thumbnail');

// Ok, we have mediafile object! Let's do something with him:
// return url for small thumbnail, for example: '/uploads/2014/12/flying-cats.jpg'
echo $mediafile->getThumbUrl('small');
// return image tag for thumbnail, for example: '<img src="/uploads/2014/12/flying-cats.jpg" alt="Летающие коты">'
echo $mediafile->getThumbImage('small'); // return url for small thumbnail
```
