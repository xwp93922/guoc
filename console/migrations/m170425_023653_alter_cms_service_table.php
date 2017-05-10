<?php

use yii\db\Migration;

class m170425_023653_alter_cms_service_table extends Migration
{
    public function up()
    {
		$this->addColumn('cms_service', 'content', $this->string()->after('description'));
    }

    public function down()
    {
        $this->dropColumn('cms_service', 'content');

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
