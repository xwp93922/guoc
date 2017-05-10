<?php

use yii\db\Migration;

/**
 * Handles the creation of table `album`.
 */
class m170228_170215_create_album_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_album', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'name'          => $this->string()->notNull(),
            'cover'       => $this->string()->null(),
            'desc'       => $this->string()->null(),
            'count_pic'   => $this->integer()->notNull()->defaultValue(0),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $this->createTable('cms_album_pic', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'album_id'    => $this->integer()->notNull(),
            'name'       => $this->string()->notNull(),
            'desc'       => $this->string()->null(),
            'url'   => $this->string()->notNull(),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_album');
        $this->dropTable('cms_album_pic');
    }
}
