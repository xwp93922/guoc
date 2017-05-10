<?php

use yii\db\Migration;

/**
 * Handles the creation of table `plan`.
 */
class m170207_093448_create_plan_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('gh_plan', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'price_origin' => $this->decimal(10,2)->defaultValue(0.00),
            'price' => $this->decimal(10,2)->defaultValue(0.00),

            'desc' => $this->text()->notNull(),
            'suggest' => $this->text()->notNull(),
            'equipments' => $this->text()->notNull(),
            'space' => $this->text()->notNull(),
            'flow' => $this->text()->notNull(),
            'month' => $this->integer()->notNull(),
            'remarks' => $this->integer()->null(),
            'image_addon' => $this->string(),

            'status' => $this->integer()->notNull()->defaultValue(10),
            'sort_val'      => $this->integer()->notNull()->defaultValue(100),

            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);

        $this->createTable('gh_plan_order', [
            'id' => $this->primaryKey(),
            'plan_id' => $this->integer()->notNull()->defaultValue(0),
            'user_id' => $this->integer()->notNull()->defaultValue(0),
            'site_id' => $this->integer()->notNull()->defaultValue(0),
            'serial_id' => $this->string()->null(),
            'transaction_id' => $this->string()->null(),
            'price' => $this->decimal(10,2),
            'count' => $this->smallInteger()->notNull()->defaultValue(1),
            'need_pay' => $this->decimal(10,2),
            'payed' => $this->decimal(10,2),
            'pay_method' => $this->smallInteger()->notNull(),

            'discount_money' =>  $this->decimal(10,2),
            'discount_note' => $this->string(),//折扣信息，比如使用了优惠券之类的

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'comment' => $this->string(),

            'plan_expired_at' => $this->integer()->defaultValue(0),
            'created_at'    => $this->integer()->notNull(),
            'updated_at'    => $this->integer()->notNull(),
        ]);


    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('gh_plan');
        $this->dropTable('gh_plan_order');
    }
}
