<?php

use yii\db\Migration;

class m170414_074942_alert_table_cms_page extends Migration
{
    public function up()
    {
    	$this->addColumn('cms_page','other',$this->string()->after('content'));
    }

    public function down()
    {
        echo "m170414_074942_alert_table_cms_page cannot be reverted.\n";

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
