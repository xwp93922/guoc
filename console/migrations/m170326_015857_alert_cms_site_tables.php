<?php

use yii\db\Migration;

class m170326_015857_alert_cms_site_tables extends Migration
{
    public function up()
    {
        $this->addColumn('cms_site','theme_id',$this->integer()->defaultValue(0)->after('lang_id'));
    }

    public function down()
    {
        $this->dropColumn('cms_site', 'theme_id');
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
