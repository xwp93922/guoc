<?php

use yii\db\Migration;

class m170411_093924_alert_friend_link_table extends Migration
{
    public function up()
    {
    	$this->addColumn('friend_link','site_id',$this->integer()->notNull()->after('id'));
    	$this->addColumn('friend_link','lang_id',$this->integer()->notNull()->after('site_id'));
    	$this->addColumn('friend_link','created_at',$this->integer()->notNull());
    	$this->addColumn('friend_link','updated_at',$this->integer()->notNull());
    }

    public function down()
    {
        echo "m170411_093924_alert_friend_link_table cannot be reverted.\n";

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
