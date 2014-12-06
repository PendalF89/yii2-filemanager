<?php

use yii\db\Schema;
use yii\db\Migration;

class m141203_175538_add_filemanager_owners_ref_mediafile_fk extends Migration
{
    public function up()
    {
        $this->addForeignKey(
            'filemanager_owners_ref_mediafile',
            'filemanager_owners',
            'mediafile_id',
            'filemanager_mediafile',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    public function down()
    {
        $this->dropForeignKey('filemanager_owners_ref_mediafile', 'filemanager_owners');
    }
}
