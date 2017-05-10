<?php

use yii\db\Migration;

class m170414_074919_crata_table_cms_exchange_table extends Migration
{
    public function up()
    {
		 $this->createTable('cms_exchange', [
            'id' => $this->primaryKey(),
            'name'       => $this->string()->notNull(),
            'code'       => $this->string()->notNull(),
            'unit'       => $this->integer()->defaultValue(100),
            'exc_buy'    => $this->decimal(10,2)->defaultValue(0.00),
            'cash_buy'     =>$this->decimal(10,2)->defaultValue(0.00),
            'cash_sale'      =>$this->decimal(10,2)->defaultValue(0.00),
            'dicount'    => $this->decimal(10,2)->defaultValue(0.00),
            'updated_at'    => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        echo "m170414_074919_crata_table_cms_exchange_table cannot be reverted.\n";

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
