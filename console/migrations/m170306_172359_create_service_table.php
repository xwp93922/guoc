<?php

use yii\db\Migration;

/**
 * Handles the creation of table `service`.
 */
class m170306_172359_create_service_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_service', [
            'id' => $this->primaryKey(),
            'lang_id'       => $this->integer()->notNull(),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'name'          => $this->string()->notNull(),
            'description'       => $this->string()->notNull(),
            'cover'       => $this->text()->notNull(),
        
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
        $this->dropTable('cms_service');
    }
}
