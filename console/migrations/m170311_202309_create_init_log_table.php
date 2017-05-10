<?php

use yii\db\Migration;

/**
 * Handles the creation of table `init_log`.
 */
class m170311_202309_create_init_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_init_log', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'theme_code' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_init_log');
    }
}
