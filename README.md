Yii2 file manager
================
This module provide interface to collect and access all mediafiles in one place. Inspired by WordPress file manager.

Features
------------
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

<img src="http://zabolotskikh.com/wp-content/uploads/2014/12/yii2-filemanager-files.png">

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

Usage
------------
```php
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