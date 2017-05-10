<?php

use yii\db\Migration;

/**
 * Handles the creation of table `share_btn`.
 */
class m170324_151207_create_share_btn_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_share_btn', [
            'id' => $this->primaryKey(),
            'lang_id' => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'type' => $this->smallInteger()->notNull(),
            'pic' => $this->string()->notNull(),
            'content' => $this->string()->notNull(),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),
            'status'        => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'    => $this->integer(),
            'updated_at'    => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_share_btn');
    }
}
