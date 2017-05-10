<?php

use yii\db\Migration;

/**
 * Handles the creation of table `nav`.
 */
class m170210_021919_create_nav_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_nav', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'name'    => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'parent_id' => $this->integer()->notNull()->defaultValue(0),
            'ext_id' => $this->integer()->notNull(),
            'ext_content' => $this->string(),
            'status' => $this->integer()->notNull()->defaultValue(10),
            'sort_val' => $this->integer()->notNull()->defaultValue(100)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_nav');
    }
}
