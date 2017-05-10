<?php

use yii\db\Migration;

class m170426_113827_alert_cms_index_config_table extends Migration
{
    public function up()
    {
    	$this->addColumn('cms_index_config', 'feature', $this->string());
    }

    public function down()
    {
       $this->dropColumn('cms_index_config', 'feature');

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
