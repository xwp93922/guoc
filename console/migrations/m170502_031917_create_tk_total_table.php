<?php

use yii\db\Migration;

/**
 * Handles the creation of table `tk_total`.
 */
class m170502_031917_create_tk_total_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('tk_total', [        		
            'id' => $this->primaryKey(),
        	'Cid' =>$this->integer(5)->notNull(),
			'GoodsID'=>$this->integer(10)->notNull(),  
        	'Que_siteid' =>$this->integer(10)->notNull(),
        	'SellerID'	=>$this->string(20)->notNull(),
        	'Quan_id'		=>$this->string(20)->notNull(),
        	'D_title' => $this->string(255)->notNull(),
        	'Title'	 =>$this->string(255)->notNull(),
        	'Dsr' =>$this->float()->notNull(),
        	'Commission_queqiao'=>$this->float()->notNull(),
        	'Jihua_link'	=>$this->string(255)->notNull(),
        	'Price'			=>$this->float()->notNull(),
        	'Jihua_shenhe'	=>$this->integer(2)->notNull(),
        	'Introduce'		=>$this->string(255)->notNull(),
        	'Sales_num'		=>$this->integer(10)->notNull(),
        	'IsTmall'		=>$this->integer(1)->notNull(),
        	'Commission_jihua' =>$this->float()->notNull(),
        	'Commission'	=>$this->float()->notNull(),
        	'Pic'			=>$this->string(255)->notNull(),
        	'Org_Price'		=>$this->float()->notNull(),
        	'Quan_receive'	=>$this->integer()->notNull(),
        	'Quan_price'	=>$this->float()->notNull(),
        	'Quan_time'		=>$this->string(50)->notNull(),
        	'Quan_link'		=>$this->string(255)->notNull(),
        	'Quan_m_link'	=>$this->string(255)->notNull(),
        	'Quan_condition'	=>$this->string(255)->notNull(),
        	'Quan_surplus'	=>$this->integer(10)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('tk_total');
    }
}
