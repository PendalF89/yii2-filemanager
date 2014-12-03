<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_173402_create_filemanager_mediafiles_table extends Migration
{
    public function up()
    {
        $this->createTable('filemanager_mediafiles', [
            'id' => 'pk',
            'mediafile_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'owner_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'owner' => Schema::TYPE_STRING . ' NOT NULL',
            'type' => Schema::TYPE_STRING . ' NOT NULL',
        ]);
    }

    public function down()
    {
        $this->dropTable('filemanager_mediafiles');
    }
}
