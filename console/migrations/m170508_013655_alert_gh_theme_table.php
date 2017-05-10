<?php

use yii\db\Migration;

class m170508_013655_alert_gh_theme_table extends Migration
{
    public function up()
    {
		$this->addColumn('gh_theme', 'home_features', $this->string()->after('features'));
    }

    public function down()
    {
        echo "m170508_013655_alert_gh_theme_table cannot be reverted.\n";

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
