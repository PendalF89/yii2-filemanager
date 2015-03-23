<?php

use yii\db\Schema;
use yii\db\Migration;

class m150323_091147_alter_filemanager_mediafile_table extends Migration
{
    public function up()
    {
        $this->alterColumn('filemanager_mediafile', 'type', Schema::TYPE_STRING . '(64) NOT NULL');
        $this->alterColumn('filemanager_mediafile', 'url', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn('filemanager_mediafile', 'size', Schema::TYPE_INTEGER . ' NOT NULL');
        $this->createIndex('url_UNIQUE', 'filemanager_mediafile', 'url', true);
    }

    public function down()
    {
        $this->dropIndex('url_UNIQUE', 'filemanager_mediafile');
        $this->alterColumn('filemanager_mediafile', 'type', Schema::TYPE_STRING . ' NOT NULL');
        $this->alterColumn('filemanager_mediafile', 'url', Schema::TYPE_TEXT . ' NOT NULL');
        $this->alterColumn('filemanager_mediafile', 'size', Schema::TYPE_STRING . ' NOT NULL');
        
        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
