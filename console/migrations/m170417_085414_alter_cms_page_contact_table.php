<?php

use yii\db\Migration;

class m170417_085414_alter_cms_page_contact_table extends Migration
{
    public function up()
    {
        $this->addColumn('cms_page_contact','site_url',$this->string()->notNull()->after('email'));
    }

    public function down()
    {
        echo "m170417_085414_alter_cms_page_contact_table cannot be reverted.\n";

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
