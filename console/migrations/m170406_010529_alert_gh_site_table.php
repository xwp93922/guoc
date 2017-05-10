<?php

use yii\db\Migration;

class m170406_010529_alert_gh_site_table extends Migration
{
    public function up()
    {
		$this->addColumn('gh_site', 'serial_id', $this->string()->after('host_name'));
    }

    public function down()
    {
        echo "m170406_010529_alert_gh_site_table cannot be reverted.\n";

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
