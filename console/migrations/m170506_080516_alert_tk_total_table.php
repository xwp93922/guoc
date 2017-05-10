<?php

use yii\db\Migration;

class m170506_080516_alert_tk_total_table extends Migration
{
    public function up()
    {
		$this->alterColumn('tk_total', 'GoodsID', $this->string(50)->notNull());
		$this->alterColumn('tk_total', 'Quan_id', $this->string(50)->notNull());
		$this->addColumn('tk_total', '	ali_click', $this->string(255)->notNull());
    }

    public function down()
    {
        echo "m170506_080516_alert_tk_total_table cannot be reverted.\n";

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
