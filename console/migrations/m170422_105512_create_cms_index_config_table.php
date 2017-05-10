<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cms_index_config`.
 */
class m170422_105512_create_cms_index_config_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_index_config', [
            'id' => $this->primaryKey(),
        	'site_id'=>$this->integer()->notNull(),
        	'lang_id'=>$this->integer()->notNull(),
        	'config_id'=>$this->integer()->notNull(),	
        	'value'=>$this->string(255),
        	'status'=>$this->integer()->defaultValue(10)	
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_index_config');
    }
}
