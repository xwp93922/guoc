<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cms_freecate`.
 */
class m170407_112720_create_cms_freecate_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_freeCate', [
            'id' => $this->primaryKey(),
        	'site_id'=>$this->integer()->notNull(),
        	'lang_id'=>$this->integer()->notNull()->defaultValue(1),
        	'content'=>$this->text(),
        	'img'=>$this->string(255),
        	'status'=>$this->integer()->notNull()->defaultValue(10), 
        	'sort'=>$this->integer()->notNull()->defaultValue(10),
        	'created_at'=>$this->integer()->notNull(), 
        	'updated_at'=>$this->integer()->notNull()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_freeCate');
    }
}
