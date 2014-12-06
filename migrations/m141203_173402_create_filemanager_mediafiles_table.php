<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_173402_create_filemanager_mediafiles_table extends Migration
{
    public function up()
    {
        $this->createTable('filemanager_mediafiles', [
            'mediafile_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'owner_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'owner' => Schema::TYPE_STRING . ' NOT NULL',
            'owner_attribute' => Schema::TYPE_STRING . ' NOT NULL',
            'PRIMARY KEY (`mediafile_id`, `owner_id`, `owner`, `owner_attribute`)',
        ]);
    }

    public function down()
    {
        $this->dropTable('filemanager_mediafiles');
    }
}
