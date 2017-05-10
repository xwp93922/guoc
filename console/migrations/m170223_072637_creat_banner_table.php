<?php

use yii\db\Migration;

class m170223_072637_creat_banner_table extends Migration
{
    public function up()
    {
        $this->createTable('cms_banner', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'pos' => $this->string()->notNull(),
        
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
        
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'necessary' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $this->createTable('cms_banner_pic', [
            'id' => $this->primaryKey(),
            'banner_id'=> $this->integer()->notNull(),
        
            'image'         => $this->text()->notNull(),
            'link' => $this->string()->notNull(),
        
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
        
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        echo "m170223_072637_creat_banner_table cannot be reverted.\n";
        
        $this->dropTable('cms_banner');

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
