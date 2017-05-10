<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cms_problem`.
 */
class m170414_021621_create_cms_problem_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('cms_problem', [
            'id' => $this->primaryKey(),
            'site_id'=>$this->integer()->notNull(),
            'lang_id'=>$this->integer()->notNull()->defaultValue(1),
            'title'=>$this->string()->notNull(),
            'content'=> $this->text(),
            'pro_pic' => $this->string(),
            'created_at'=>$this->integer()->notNull(),
            'view_count'=>$this->integer()->notNull()->defaultValue(0),
            'status'=>$this->integer()->notNull()->defaultValue(10),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cms_problem');
    }
}
