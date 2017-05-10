<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cms_join_info`.
 */
class m170408_101438_create_cms_join_info_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_join_info', [
            'id' => $this->primaryKey(),
        	'site_id'=>$this->integer()->notNull(),
        	'lang_id'=>$this->integer()->notNull()->defaultValue(1),
        	'name'=>$this->string()->notNull(), 
        	'phone'=>$this->integer()->notNull(),
        	'mail'=>$this->string()->notNull(), 
        	'content'=>$this->text(),
        	'created_at'=>$this->integer()->notNull(),
        	'status'=>$this->integer()->notNull()->defaultValue(10),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_join_info');
    }
}
