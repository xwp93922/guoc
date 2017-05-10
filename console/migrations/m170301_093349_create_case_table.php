<?php

use yii\db\Migration;

/**
 * Handles the creation of table `case`.
 */
class m170301_093349_create_case_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_case_category', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'parent_id' => $this->integer()->defaultValue(0)->notNull(),

            'name'          => $this->string()->notNull(),
            'description'   => $this->string()->notNull(),
            'meta_keywords'         => $this->string(),
            'meta_description'      => $this->string(),

            'image_main' => $this->string(),
            'image_node' => $this->string(),

            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $this->createTable('cms_case', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'category_id'   => $this->integer()->notNull()->defaultValue(0),
            'name'          => $this->string()->notNull(),
            'summary'       => $this->string()->notNull(),
            'content'       => $this->text()->null(),
            'meta_keywords'         => $this->string(),
            'meta_description'      => $this->string(),
        
            'image_main' => $this->string(),
            'image_node' => $this->string(),
        
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
        $this->dropTable('cms_case');
        $this->dropTable('cms_case_category');
    }
}
