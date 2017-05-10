<?php

use yii\db\Migration;

/**
 * Handles the creation of table `category`.
 */
class m161127_150132_create_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_category', [
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
            'banner' => $this->string()->null(),

            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'necessary' => $this->smallInteger()->notNull()->defaultValue(0),
            'type' => $this->string(20)->null(),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_category');
    }
}
