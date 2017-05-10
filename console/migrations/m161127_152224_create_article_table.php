<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m161127_152224_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_article', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'category_id'   => $this->integer()->notNull(),


            'name'          => $this->string()->notNull(),
            'summary'       => $this->string()->notNull(),
            'content'       => $this->text()->notNull(),
            'meta_keywords'         => $this->string(),
            'meta_description'      => $this->string(),

            'image_main' => $this->string(),
            'image_node' => $this->string(),
            
            'view_count' => $this->integer()->notNull()->defaultValue(0),

            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'recommend'  => $this->smallInteger()->notNull()->defaultValue(0),

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
        $this->dropTable('cms_article');
    }
}
