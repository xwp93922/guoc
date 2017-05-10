<?php

use yii\db\Migration;

/**
 * Handles the creation of table `top_banner`.
 */
class m170313_153759_create_top_banner_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_top_banner', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'pos' => $this->string()->notNull(),
            'pic' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'desc' => $this->string()->notNull(),
        
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_top_banner');
    }
}
