<?php

use yii\db\Migration;

class m170412_021628_alert_cms_page_table extends Migration
{
    public function up()
    {
    	$this->addColumn('cms_page','parent_id',$this->integer()->notNull()->defaultValue(0)->after('id'));
    	$this->addColumn('cms_page','type',$this->integer()->notNull()->defaultValue(0)->after('id'));
    }

    public function down()
    {
        echo "m170412_021628_alert_cms_page_table cannot be reverted.\n";

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
