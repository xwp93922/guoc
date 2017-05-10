<?php

use yii\db\Migration;

class m170316_161259_create_config_tables extends Migration
{
    public function up()
    {
        $this->createTable('cms_album_config', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'top_banner' => $this->string()->null(),
            'top_banner_name' => $this->string()->null(),
            'top_banner_desc' => $this->string()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
        
        $this->createTable('cms_case_config', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'top_banner' => $this->string()->null(),
            'top_banner_name' => $this->string()->null(),
            'top_banner_desc' => $this->string()->null(),
            'homepage_name' => $this->string()->null(),
            'homepage_desc' => $this->string()->null(),
            'more_btn_name' => $this->string()->null(),
            'use_category' => $this->integer()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
        
        $this->createTable('cms_service_config', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'homepage_name' => $this->string()->null(),
            'homepage_desc' => $this->string()->null(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);
    }

    public function down()
    {
        echo "m170316_161259_create_config_tables cannot be reverted.\n";
        
        $this->dropTable('cms_album_config');
        $this->dropTable('cms_case_config');
        $this->dropTable('cms_service_config');

        return false;
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
