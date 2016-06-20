<?php

use yii\db\Migration;

class m160616_000010_add_filemanager_tags extends Migration
{
    public function up()
    {
        $this->createTable('filemanager_tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
        ]);

        $this->createTable('filemanager_mediafile_tag', [
            'mediafile_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'filemanager_mediafile_tag_mediafile_id__mediafile_id',
            'filemanager_mediafile_tag',
            'mediafile_id',
            'filemanager_mediafile',
            'id',
            'CASCADE',
            'CASCADE'
            );
        $this->addForeignKey(
            'filemanager_mediafile_tag_tag_id__tag_id',
            'filemanager_mediafile_tag',
            'tag_id',
            'filemanager_tag',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('filemanager_mediafile_tag');
        $this->dropTable('filemanager_tag');
    }
}
