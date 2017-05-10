<?php

use yii\db\Migration;

class m170505_070253_alert_cms_service_table extends Migration
{
    public function up()
    {
		$this->addColumn('cms_service', 'cover_hover', $this->string()->after('cover'));
    }

    public function down()
    {
        echo "m170505_070253_alert_cms_service_table cannot be reverted.\n";

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
