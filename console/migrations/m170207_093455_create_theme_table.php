<?php

use yii\db\Migration;

/**
 * Handles the creation of table `theme`.
 */
class m170207_093455_create_theme_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gh_theme_category', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'sort_val' => $this->integer()->notNull()->defaultValue(0),
            'necessary' => $this->smallInteger()->notNull()->defaultValue(0),

            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->createTable('gh_theme', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull()->unique(),
            'desc' => $this->string()->notNull(),
            'price_origin' => $this->decimal(10,2)->defaultValue(0.00),
            'price' => $this->decimal(10,2)->defaultValue(0.00),
            'features' => $this->string(),
            'image_pc' => $this->string()->null(),
            'image_pad' => $this->string()->null(),
            'image_phone' => $this->string()->null(),

            'image_addon' => $this->string()->null(),

            'type' => $this->integer()->notNull()->defaultValue(0),
            'necessary' => $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->createTable('cms_theme', [
            'id' => $this->primaryKey(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'theme_id' => $this->string()->notNull(),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
        
        $now = time();
        $this->batchInsert('gh_theme_category', ['name','status','necessary','created_at','updated_at'], [
            ['默认主题',10,1,$now,$now],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('gh_theme');
        $this->dropTable('gh_theme_category');
    }
}
